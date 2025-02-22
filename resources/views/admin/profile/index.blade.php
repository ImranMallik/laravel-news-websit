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
                <h2 class="section-title">Hi, Ujang!</h2>
                <p class="section-lead">
                    {{ __('Change information about yourself on this page') }}.
                </p>

                <div class="row mt-sm-4">

                    <div class="col-12 col-md-6">
                        <div class="card">
                            <form method="post"
                                action="{{ route('admin.dashboard.profile.update', auth()->guard('admin')->user()->id) }}"
                                class="needs-validation" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>{{ __('Edit Profile') }}</h4>
                                </div>
                                <div class="card-body">

                                    <div id="image-preview" class="image-preview ml-4 mb-4"
                                        style="width:200px; height:193px">
                                        <label for="image-upload" id="image-label">{{ __('Choose Image') }}</label>
                                        <input type="file" name="image" id="image-upload">
                                        @error('image')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group  col-12">
                                        <label>{{ __('Name') }}</label>
                                        <input type="text" class="form-control" value="{{ $user->name }}"
                                            name="name">
                                        <div class="invalid-feedback">
                                            {{ __('Please fill in the name') }}
                                        </div>
                                        @error('name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group  col-12">
                                        <label>{{ __('Email') }}</label>
                                        <input type="email" class="form-control" value="{{ $user->email }}"
                                            name="email">
                                        <div class="invalid-feedback">
                                            '{{ __('Please fill in the email') }}'
                                        </div>
                                        @error('email')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>


                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">{{ __('Save Changes') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <form method="post" class="needs-validation" novalidate="">
                                <div class="card-header">
                                    <h4>{{ __('Update Password') }}</h4>
                                </div>
                                <div class="card-body">

                                    <div class="form-group  col-12">
                                        <label>{{ __('Old Password') }}</label>
                                        <input type="text" class="form-control" value="" required>
                                        <div class="invalid-feedback">
                                            {{ __('Please fill in the name') }}
                                        </div>
                                    </div>
                                    <div class="form-group  col-12">
                                        <label>{{ __('New Password') }}</label>
                                        <input type="email" class="form-control" value="" name="password">
                                        <div class="invalid-feedback">
                                            '{{ __('Please fill in the email') }}'
                                        </div>
                                    </div>
                                    <div class="form-group  col-12">
                                        <label>{{ __('Confirmed Password') }}</label>
                                        <input type="email" class="form-control" value="">
                                        <div class="invalid-feedback">
                                            '{{ __('Please fill in the email') }}'
                                        </div>
                                    </div>


                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">{{ __('Save Changes') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
