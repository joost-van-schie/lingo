<form>
    <div class="form-group">
        <label for="word">Woord:</label>
        <input type="text" class="form-control" id="word" placeholder="Type een woord met 5 letters." wire:model="word">
        @error('word') <span class="text-danger">{{ $message }}</span>@enderror
    </div>
    <button wire:click.prevent="guess()" class="btn btn-dark">Verstuur</button>
    <button wire:click.prevent="stop()" class="btn btn-danger">Stop het spel</button>
</form>

@unless(empty($validatedWords))
    <table class="table table-bordered mt-5">
        <thead>
        <tr>
            <th>Pogingen ({{$attempts}}/{{$maxAttempts}})</th>
        </tr>
        </thead>
        <tbody>
        @foreach($validatedWords as $word)
            <tr>
                <td>
                    @foreach($word['chars'] as $char)
                        <span class="badge badge-secondary" style="background-color: {{$char['color']}}">
                            {{$char['char']}}
                        </span>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endunless
