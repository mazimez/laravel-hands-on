@extends('UI.base.main')
@push('styles')
<style>
    .card-count {
        font-size: 2rem;
        color: #242526;
    }
    .active-count{
        color: #28a745;
    }
    .unverified-count{
        color: #fd7e14;
    }
    .blocked-count{
        color: #dc3545;
    }
</style>
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <i class="fa fa-users"></i>
                        Users
                    </div>
                    <div class="card-body">
                        <h5 class="card-title card-count">{{ $user_count }}</h5>
                        <p class="card-text">Number of registered users</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <i class="fa fa-check"></i>
                        Posts
                    </div>
                    <div class="card-body">
                        <h5 class="card-title card-count active-count">{{ $active_post_count }}</h5>
                        <p class="card-text">Number of Active posts</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <i class="fa fa-times"></i>
                        Posts
                    </div>
                    <div class="card-body">
                        <h5 class="card-title card-count unverified-count">{{ $unverified_post_count }}</h5>
                        <p class="card-text">Number of Unverified posts</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <i class="fa fa-ban"></i>
                        Posts
                    </div>
                    <div class="card-body">
                        <h5 class="card-title card-count blocked-count">{{ $blocked_post_count }}</h5>
                        <p class="card-text">Number of Blocked posts</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
