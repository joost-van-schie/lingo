<form>
    <div class="form-group">
        <label for="name">Wat is je naam:</label>
        <input type="text" class="form-control" id="name" placeholder="Naam" wire:model="name">
        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
    </div>
    <button wire:click.prevent="start()" class="btn btn-success">Start Lingo</button>
</form>
