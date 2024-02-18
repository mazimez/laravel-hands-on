<form wire:submit.prevent="storeData">

    <div class="row">
        <div class="col-2">
            <label for="data.name">Name</label>
            <input type="text" id="data.name" wire:model="data.name" />
            @error('data.name')
                <strong>{{ $message }}</strong>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <label for="data.email">Email</label>
            <input type="text" id="data.email" wire:model="data.email" />
            @error('data.email')
                <strong>{{ $message }}</strong>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <label for="data.number">Number</label>
            <input type="text" id="data.number" wire:model="data.number" />
            @error('data.number')
                <strong>{{ $message }}</strong>
            @enderror
        </div>
    </div>
    <div class="row">
        <button wire:click="showData">Show Data</button>
        <button type="submit">Submit</button>
    </div>

</form>
