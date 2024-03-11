<form wire:submit.prevent="storeData">

    <div class="row">
        <div class="col-2">
            <x-input type="text" model="user.name" name="Name"/>
            <x-error name="user.name" />
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            @if ($user->id)
                <x-input type="email" model="user.email" name="Email" isDisabled=1/>
            @else
                <x-input type="email" model="user.email" name="Email"/>
            @endif

            <x-error name="user.email" />
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <x-input type="number" model="user.phone_number" name="Number" />
            <x-error name="user.phone_number" />
        </div>
    </div>

    @if ($user->profile_image)
    <div class="row">
        <div class="col-2">
            <label for="image">Profile image</label>
            <img id = "image" class="mb-6 border" style="object-fit: contain; max-width: 200px" src={{ Storage::url($user->profile_image) }}>
        </div>
    </div>
    @endif




    <div class="row">
        <div>
            <x-button name="Submit" type="submit" target="storeData" />
        </div>
    </div>

</form>
