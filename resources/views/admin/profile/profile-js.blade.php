<script>
    $(document).ready(function() {
        // Show Default Image
        $('.image-preview').css({
            "background-image": "url({{ asset($user->image) }})",
            "background-position": "center center",
            "background-repeat": "no-repeat",
            "background-size": "cover"
        });
        //End Show Default Image

        // ===========================
        // ✅ Admin Profile Update AJAX
        // ===========================
        $('#profileForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let nameField = $('[name="name"]');
            let emailField = $('[name="email"]');
            let saveBtn = $('#saveBtn');
            let loadingSpinner = $('#loadingSpinner');
            let hasError = false;

            // Disable button and show spinner
            saveBtn.prop('disabled', true);
            loadingSpinner.removeClass('d-none');

            // Remove previous error styles
            $('.form-control').removeClass('is-invalid');


            // Validation Checks
            if (nameField.val().trim() === '') {
                nameField.addClass('is-invalid');

                hasError = true;
            }

            if (emailField.val().trim() === '') {
                emailField.addClass('is-invalid');

                hasError = true;
            }

            if (hasError) {
                saveBtn.prop('disabled', false);
                loadingSpinner.addClass('d-none');
                return;
            }

            // AJAX Request
            $.ajax({
                url: "{{ route('admin.dashboard.profile.update', auth()->guard('admin')->user()->id) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function(response) {
                    saveBtn.prop('disabled', false);
                    loadingSpinner.addClass('d-none');

                    if (response.responseJSON.errors) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            let inputField = $('[name="' + key + '"]');
                            inputField.addClass('is-invalid');
                            $('.' + key + '_error').text(value[0]);
                        });
                        toastr.error('Please check the form for errors.', 'Error');
                    }
                }
            });
        });
        // End

        // ===========================
        // ✅ Update Password AJAX
        // ===========================
        $('#passwordForm').on('submit', function(e) {
            e.preventDefault();

            let saveBtn = $('#savePasswordBtn');
            let oldPassword = $('[name="old_password"]');
            let newPassword = $('[name="password"]');
            let confirmPassword = $('[name="password_confirmation"]');
            let loadingSpinner = $('#passwordLoadingSpinner');
            let hasError = false;

            // Clear previous errors
            $('.form-control').removeClass('is-invalid');

            // Validation Checks (Frontend)
            if (oldPassword.val().trim() === '') {
                oldPassword.addClass('is-invalid');

                hasError = true;
            }
            if (newPassword.val().trim() === '') {
                newPassword.addClass('is-invalid');
                hasError = true;
            }
            if (confirmPassword.val().trim() === '') {
                confirmPassword.addClass('is-invalid');

                hasError = true;
            }
            if (newPassword.val().trim() !== confirmPassword.val().trim()) {
                confirmPassword.addClass('is-invalid');

                hasError = true;
            }

            if (hasError) {
                return;
            }

            // Disable button and show spinner
            saveBtn.prop('disabled', true);
            loadingSpinner.removeClass('d-none');

            // Send AJAX request
            $.ajax({
                url: "{{ route('admin.dashboard.password.update', auth()->guard('admin')->user()->id) }}",
                type: "POST", // Ensure it is a POST request
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // CSRF Token
                    old_password: oldPassword.val(),
                    password: newPassword.val(),
                    password_confirmation: confirmPassword.val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                        // toast(response.message, 'success');

                        // Reset the form fields after success
                        $('#passwordForm')[0].reset();

                        // Re-enable button and hide spinner
                        saveBtn.prop('disabled', false);
                        loadingSpinner.addClass('d-none');
                    }
                },
                error: function(response) {
                    saveBtn.prop('disabled', false);
                    loadingSpinner.addClass('d-none');

                    if (response.responseJSON.errors) {
                        $.each(response.responseJSON.errors, function(key, value) {
                            let inputField = $('[name="' + key + '"]');
                            inputField.addClass('is-invalid');
                            $('.' + key + '_error').text(value[0]);
                        });

                        // Show an error message
                        toastr.error('Please check the form for errors.',
                            'Error');
                    }
                }
            });
        });


        // end
    });
</script>
