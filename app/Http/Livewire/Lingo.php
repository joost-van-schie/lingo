<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Game;

class Lingo extends Component
{
    public $name, $word, $game_id, $guessedWords, $validatedWords, $activeGameExists, $attempts, $maxAttempts;
    private $activeGame;

    public function render()
    {
        $this->wonGames = Game::won()
            ->orderBy('attempts', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        $this->activeGameExists = Game::active()->exists();
        $this->guessedWords = [];

        if ($this->activeGameExists) {
            $this->activeGame = Game::active()->first();
            $this->game_id = $this->activeGame->id;
            $this->validatedWords = $this->validateWords($this->activeGame->guessed_words);
            $this->attempts = $this->activeGame->attempts;
            $this->maxAttempts = 5;
        }

        return view('livewire.lingo');
    }

    public function start()
    {
        $this->validate([
            'name' => 'required',
        ]);

        Game::create([
            'name' => $this->name,
            'answer' => $this->getRandomAnswer(),
        ]);

        session()->flash('message', 'Lingo is gestart!');
    }

    public function guess()
    {
        $this->validate([
            'word' => 'required|alpha|size:5',
        ]);

        $this->word = strtoupper($this->word);
        $game = Game::find($this->game_id);

        $this->guessedWords = $game->guessed_words;
        $this->guessedWords[] = $this->word;
        $this->attempts = count($this->guessedWords);

        $game->update([
            'guessed_words' => $this->guessedWords,
            'attempts'      => $this->attempts,
            'state'         => $this->getState($game->answer),
        ]);

        $this->word = '';
    }

    public function stop()
    {
        Game::find($this->game_id)->delete();
        $this->validatedWords = '';
        session()->flash('message', 'Lingo is gestopt.');
    }

    private function validateWords($words) : array
    {
        if (empty($words)) {
            return [];
        }

        foreach ($words as $word) {
            $chars = str_split($word);
            $validatedWords[] = [
                'word' => $word,
                'chars' => $this->validateChars($chars)
            ];
        }

        return $validatedWords;
    }

    private function validateChars(array $chars) : array
    {
        $validatedChars = [];

        for ($i = 0; $i < count($chars); $i++) {
            $validatedChars[] = [
                'char'  => $chars[$i],
                'color' => $this->getColor($chars[$i], $i)
            ];
        }

        return $validatedChars;
    }

    private function getColor($char, $index) : string
    {
        $answer = str_split($this->activeGame->answer);

        if ($char === $answer[$index]) {
            return 'red';
        }

        if (str_contains($this->activeGame->answer, $char)) {
            return 'yellow';
        }

        return 'grey';
    }

    private function getState($answer) : string
    {
        if ($this->word === $answer) {
            session()->flash('message', 'Je hebt het juiste woord geraden.');
            return Game::STATE_WON;
        }

        if ($this->attempts === $this->maxAttempts) {
            session()->flash('message', 'Je hebt helaas verloren.');
            return Game::STATE_LOST;
        }

        return Game::STATE_ACTIVE;
    }

    private function getRandomAnswer() : string
    {
        $answers = config('answers.words');
        $randomInt = rand(0,count($answers));
        return $answers[$randomInt];
    }
}
