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
            e.preventDefault();

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
                        $('table').DataTable().ajax.reload(null, false);
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
