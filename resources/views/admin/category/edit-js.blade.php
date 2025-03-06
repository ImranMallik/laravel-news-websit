 <script>
     $(document).ready(function() {
         $('#language-select').on('change', function() {
             let value = $(this).val();
             let name = $(this).children(':selected').text();
             // $('#slug').val(value);
             $('#name').val(name);
         })

         // Ajax For Store Data
         $('#editCategoryForm').on('submit', function(e) {
             e.preventDefault();

             let form = $(this);
             let formData = form.serialize();
             let submitBtn = $('#submitBtn');
             let categoryId = $('#category_id').val();

             // Disable button to prevent multiple submissions

             let updateUrl = "{{ route('admin.category.update', ':id') }}".replace(':id', categoryId);
             submitBtn.prop('disabled', true).text('Updating...');

             $.ajax({
                 url: updateUrl,
                 type: "PUT",
                 data: formData,
                 dataType: "json",
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                         'content')
                 },
                 success: function(response) {
                     if (response.success) {
                         toastr.success(response.message);

                         // Reload datatable without refreshing the page
                         $('table').DataTable().ajax.reload(null, false);

                         // Redirect immediately instead of waiting
                         window.location.href = "{{ route('admin.category.index') }}";
                     } else {
                         toastr.error(response.message);
                     }

                     submitBtn.prop('disabled', false).text('Update');
                 },
                 error: function(xhr) {
                     submitBtn.prop('disabled', false).text('Update');

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
