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
