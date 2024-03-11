@props([
    'model',
    'name',
    'type',
    'isDisabled'=>false
])
<label for="{{ $model }}">{{ $name }}</label>
<input type="{{ $type }}" id="{{ $model }}" wire:model="{{ $model }}" @if ($isDisabled) disabled @endif/>
<i wire:loading.class="loader" wire:target="{{ $model }}"></i>
