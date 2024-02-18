@extends('UI.base.main')
@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush


@section('content')
    @livewire('test-component', ['data' => $data])
@endsection
