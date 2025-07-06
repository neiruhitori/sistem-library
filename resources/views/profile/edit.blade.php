@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Profile</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="card card-danger card-outline">
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
