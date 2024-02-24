@extends('UI.base.main')

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            @livewire($livewire_component, $livewire_data ?? [])
        </div>
    </div>
@endsection

@section('styles')
    @livewireStyles
@endsection

@section('scripts')
    @livewireScripts
@endsection
