@extends('admin.layouts.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Language</h1>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Languages</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.languages.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <p>write something here</p>
                </div>
            </div>
    </div>
    </section>
@endsection
