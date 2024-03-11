<form wire:submit.prevent="storeData">

    <div class="row">
        <div class="col-2">
            <x-input type="text" model="data.name" name="Name"/>
            <x-error name="data.name" />
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <x-input type="email" model="data.email" name="Email"/>
            <x-error name="data.email" />
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <x-input type="number" model="data.number" name="Number"/>
            <x-error name="data.number" />
        </div>
    </div>
    <div class="row">
        <div>
            <x-button name="Show Data" type="button" target="showData" />
        </div>
        <div>
            <x-button name="Submit" type="submit" target="storeData" />
        </div>
    </div>

</form>
