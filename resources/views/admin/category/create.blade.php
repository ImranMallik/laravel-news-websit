@extends('admin.layouts.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Category') }}</h1>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('Create Category') }}</h4>

                </div>
                <div class="card-body">
                    <form id="categoryForm">
                        @csrf

                        <div class="form-group">
                            <label for="">{{ __('Language') }}</label>
                            <select name="language" id="language-select" class="form-control select2">
                                <option value="">--Select--</option>
                                @foreach ($language as $lang)
                                    <option value="{{ $lang->language }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Name') }}</label>
                            <input name="name" type="text" readonly id="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Show at Nav') }}</label>
                            <select name="show_at_nav" class="form-control">
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
    <script>
        $(document).ready(function() {
            $('#language-select').on('change', function() {
                let value = $(this).val();
                let name = $(this).children(':selected').text();
                // $('#slug').val(value);
                $('#name').val(name);
            })

            // Ajax For Store Data
            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();
                let submitBtn = $('#submitBtn');

                // Disable button to prevent multiple submissions
                submitBtn.prop('disabled', true).text('Creating...');

                $.ajax({
                    url: "{{ route('admin.category.store') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('table').DataTable().ajax.reload(null, false);
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.category.index') }}";
                            }, 2000);
                        } else {
                            toastr.error(response.message);
                        }
                        submitBtn.prop('disabled', false).text('Create');
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).text('Create');

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error("An error occurred. Please try again.");
                        }
                    }
                });
            });


        });
    </script>
@endpush
