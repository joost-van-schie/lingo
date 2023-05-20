<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\CreateGame;
use App\Http\Livewire\Lingo;
use App\Models\Game;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LingoTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Lingo::class);

        $component->assertStatus(200);
    }

    /** @test */
    function page_contains_lingo_component()
    {
        $this->get('/')->assertSeeLivewire('lingo');
    }

    /** @test */
    function can_create_game()
    {
        Livewire::test(Lingo::class)
            ->set('name', 'John')
            ->call('start');

        $this->assertTrue(Game::whereName('John')->exists());
    }

    /** @test */
    function name_is_required()
    {
        Livewire::test(Lingo::class)
            ->set('name', '')
            ->call('start')
            ->assertHasErrors(['name' => 'required']);
    }
}
