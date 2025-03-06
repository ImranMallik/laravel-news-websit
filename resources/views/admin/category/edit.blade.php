@extends('admin.layouts.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Category') }}</h1>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('Update Category') }}</h4>

                </div>
                <div class="card-body">
                    <form id="editCategoryForm">
                        @csrf
                        <input type="hidden" id="category_id" name="category_id" value="{{ $category->id }}">
                        <div class="form-group">
                            <label for="">{{ __('Language') }}</label>
                            <select name="language" id="language-select" class="form-control select2">
                                <option value="">--Select--</option>
                                @foreach ($language as $lang)
                                    <option {{ $lang->language === $category->language ? 'selected' : '' }}
                                        value="{{ $lang->language }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Name') }}</label>
                            <input name="name" type="text" value="{{ $category->name }}" readonly id="name"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Show at Nav') }}</label>
                            <select name="show_at_nav" class="form-control">
                                <option {{ $category->show_at_nav === 1 ? 'selected' : '' }} value="1">
                                    {{ __('Yes') }}</option>
                                <option {{ $category->show_at_nav === 0 ? 'selected' : '' }}value="0">{{ __('No') }}
                                </option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="">{{ __('Status') }}</label>
                            <select name="status" class="form-control">
                                <option {{ $category->status === 1 ? 'selected' : '' }} value="1">{{ __('Active') }}
                                </option>
                                <option {{ $category->status === 0 ? 'selected' : '' }} value="0">
                                    {{ __('Inactive') }}</option>
                            </select>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-primary">{{ __('Update') }}</button>
                    </form>

                </div>
            </div>
    </div>
    </section>
@endsection

@push('scripts')
    @include('admin.category.edit-js')
@endpush
