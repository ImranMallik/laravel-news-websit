@extends('admin.layouts.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">{{ __('Profile') }}</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Hi, {{ $user->name }}</h2>
                <p class="section-lead">
                    {{ __('Change information about yourself on this page') }}.
                </p>

                <div class="row mt-sm-4">

                    <div class="col-12 col-md-6">
                        <div class="card">
                            <form id="profileForm" enctype="multipart/form-data">
                                @csrf

                                <div class="card-header">
                                    <h4>{{ __('Edit Profile') }}</h4>
                                </div>

                                <div class="card-body">
                                    <!-- Image Upload -->
                                    <div id="image-preview" class="image-preview ml-4 mb-4"
                                        style="width:200px; height:193px">
                                        <label for="image-upload" id="image-label">{{ __('Choose Image') }}</label>
                                        <input type="file" name="image" id="image-upload" class="form-control">
                                        <input type="hidden" name="old_image" class="form-control"
                                            value="{{ $user->image }}">

                                    </div>

                                    <!-- Name Input -->
                                    <div class="form-group col-12">
                                        <label>{{ __('Name') }}</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', $user->name) }}">

                                    </div>

                                    <!-- Email Input -->
                                    <div class="form-group col-12">
                                        <label>{{ __('Email') }}</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', $user->email) }}">

                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" id="saveBtn" class="btn btn-primary">
                                        <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner"></span>
                                        {{ __('Save Changes') }}
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <form id="passwordForm">
                                @csrf
                                <div class="card-header">
                                    <h4>{{ __('Update Password') }}</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Old Password -->
                                    <div class="form-group col-12">
                                        <label>{{ __('Old Password') }}</label>
                                        <input type="password" class="form-control update-password" name="old_password">

                                    </div>

                                    <!-- New Password -->
                                    <div class="form-group col-12">
                                        <label>{{ __('New Password') }}</label>
                                        <input type="password" class="form-control update-password" name="password">

                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="form-group col-12">
                                        <label>{{ __('Confirm Password') }}</label>
                                        <input type="password" class="form-control update-password"
                                            name="password_confirmation">

                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" id="savePasswordBtn" class="btn btn-primary">
                                        <span class="spinner-border spinner-border-sm d-none"
                                            id="passwordLoadingSpinner"></span>
                                        {{ __('Save Changes') }}
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    @include('admin.profile.profile-js');
@endpush
