@extends('admin.layouts.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Language</h1>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Create Language</h4>

                </div>
                <div class="card-body">
                    <form id="languageForm">
                        @csrf

                        <div class="form-group">
                            <label for="">Language</label>
                            <select name="language" id="language-select" class="form-control select2">
                                <option value="">--Select--</option>
                                @foreach (config('language') as $key => $lang)
                                    <option value="{{ $key }}">{{ $lang['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Name</label>
                            <input name="name" type="text" readonly id="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Slug</label>
                            <input name="slug" type="text" readonly id="slug" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Is it default?</label>
                            <select name="default" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-primary">Create</button>
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
                $('#slug').val(value);
                $('#name').val(name);
            })

            // Ajax For Store Data
            $('#languageForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                let form = $(this);
                let formData = form.serialize();
                let submitBtn = $('#submitBtn');

                let hasError = false;
                form.find('input, select').each(function() {
                    if ($(this).val() === '') {
                        hasError = true;
                        let fieldLabel = $(this).prev('label').text();
                        toastr.error(fieldLabel + ' is required');
                    }
                });

                if (hasError) return;


                submitBtn.prop('disabled', true).text('Creating...');

                $.ajax({
                    url: "{{ route('admin.languages.store') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);

                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.languages.index') }}";
                            }, 2000);
                        } else {
                            toastr.error(response.message);
                        }
                        submitBtn.prop('disabled', false).text('Create');
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                        submitBtn.prop('disabled', false).text('Create');
                    }
                });
            });

        });
    </script>
@endpush
