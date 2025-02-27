@extends('admin.layouts.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Language') }}</h1>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('Create Language') }}</h4>

                </div>
                <div class="card-body">
                    <form id="languageForm">
                        @csrf

                        <div class="form-group">
                            <label for="">{{ __('Language') }}</label>
                            <select name="language" id="language-select" class="form-control select2">
                                <option value="">--Select--</option>
                                @foreach (config('language') as $key => $lang)
                                    <option value="{{ $key }}">{{ $lang['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Name') }}</label>
                            <input name="name" type="text" readonly id="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Slug') }}</label>
                            <input name="slug" type="text" readonly id="slug" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Is it default?') }}</label>
                            <select name="default" class="form-control">
                                <option value="1">{{ __('Yes') }}</option>
                                <option value="0">{{ __('No') }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Status') }}</label>
                            <select name="status" class="form-control">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Inactive') }}</option>
                            </select>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-primary">{{ __('Create') }}</button>
                    </form>

                </div>
            </div>
    </div>
    </section>
@endsection

@push('scripts')
    @include('admin.languages.create-language-js');
@endpush
