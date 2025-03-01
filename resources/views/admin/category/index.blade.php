@extends('admin.layouts.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Category') }}</h1>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('All Category') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{ __('Create New') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <p>write something here</p> --}}
                    {{ $dataTable->table(['class' => 'table table-bordered']) }}
                </div>
            </div>
    </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
