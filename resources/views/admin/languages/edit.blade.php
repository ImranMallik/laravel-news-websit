@extends('admin.layouts.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Language') }}</h1>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('Edit Language') }}</h4>
                </div>
                <div class="card-body">
                    <form id="updatelanguageForm" action="{{ route('admin.languages.update', $edit_data->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="language-select">{{ __('Language') }}</label>
                            <select name="language" id="language-select" class="form-control select2">
                                <option value="">--Select--</option>
                                @foreach ($languages as $key => $lang)
                                    <option value="{{ $key }}"
                                        {{ $edit_data->language == $key ? 'selected' : '' }}>
                                        {{ $lang['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input name="name" type="text" id="name" class="form-control"
                                value="{{ $edit_data->name }}" readonly required>
                        </div>

                        <div class="form-group">
                            <label for="slug">{{ __('Slug') }}</label>
                            <input name="slug" type="text" id="slug" class="form-control"
                                value="{{ $edit_data->slug }}" readonly required>
                        </div>

                        <div class="form-group">
                            <label for="default">{{ __('Is it default?') }}</label>
                            <select name="default" class="form-control">
                                <option value="1" {{ $edit_data->default == 1 ? 'selected' : '' }}>
                                    {{ __('Yes') }}</option>
                                <option value="0" {{ $edit_data->default == 0 ? 'selected' : '' }}>
                                    {{ __('No') }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">{{ __('Status') }}</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $edit_data->status == 1 ? 'selected' : '' }}>{{ __('Active') }}
                                </option>
                                <option value="0" {{ $edit_data->status == 0 ? 'selected' : '' }}>
                                    {{ __('Inactive') }}</option>
                            </select>
                        </div>

                        <button type="submit" id="updateBtn" class="btn btn-primary">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
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
            $('#updatelanguageForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();
                let submitBtn = $('#updateBtn');

                let hasError = false;
                form.find('input, select').each(function() {
                    if ($(this).val() === '') {
                        hasError = true;
                        let fieldLabel = $(this).prev('label').text();
                        toastr.error(fieldLabel + ' is required');
                    }
                });

                if (hasError) return;

                submitBtn.prop('disabled', true).text('Updating...');
                let languageId = "{{ $edit_data->id }}";
                let updateUrl = "{{ route('admin.languages.update', ':id') }}";
                updateUrl = updateUrl.replace(':id', languageId);

                $.ajax({
                    url: updateUrl,
                    type: "PUT",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            toastr.success(response.message);

                            $('table').DataTable().ajax.reload(null, false);

                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.languages.index') }}";
                            }, 2000);
                        } else {
                            toastr.error(response.message);
                        }

                        submitBtn.prop('disabled', false).text(
                            'Update');
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).text(
                            'Update');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON;
                            toastr.error(errors.message); // Shows validation error message
                        } else if (xhr.status === 500) {
                            toastr.error("Something went wrong. Please try again.");
                        } else {
                            toastr.error("An unknown error occurred.");
                        }
                    }
                });
            });

        });
    </script>
@endpush
