<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if($activeGameExists)
        @include('livewire.game.guess')
    @else
        @include('livewire.game.start')
        @include('livewire.game.scoreboard')
    @endif
</div>
