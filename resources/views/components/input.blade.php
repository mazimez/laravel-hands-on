<label for="{{ $model }}">Name</label>
<input type="{{ $type }}" id="{{ $model }}" wire:model="{{ $model }}" />
<i wire:loading.class="loader" wire:target="{{ $model }}"></i>
