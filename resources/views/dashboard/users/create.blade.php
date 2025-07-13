<x-backend.dashboard title="Create User">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Add new User</h1>
        <a class="btn btn-primary" href="{{ route('admin.users.index') }}"><i class="fas fa-long-arrow-alt-left"></i>
            All Users</a>

    </div>


    <div class="card">
        <div class="card-body">
            <form id="create-form">
                @csrf
                <div class="mb-3">
                    @include('dashboard.users._form')
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                    Save</button>
            </form>
        </div>
    </div>



    @push('js')
        <script>
           $('#create-form').submit(function(event) {
    event.preventDefault();

    let formData = new FormData();
    formData.append('name', $('#name').val());
    formData.append('email', $('#email').val());
    formData.append('phone', $('#phone').val());
    formData.append('address', $('#address').val());
    formData.append('active', $('#active').is(':checked') ? 1 : 0);

    $.ajax({
        type: 'POST',
        url: '{{ route('admin.users.store') }}',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            toastr.options.timeOut = 3000;
            toastr.success(response.message || 'User created successfully');
            $('#create-form')[0].reset();
            $('#create-form .is-invalid').removeClass('is-invalid');
            $('#create-form .invalid-feedback').text('');
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                // Name validation
                if (errors.name) {
                    $('#name').addClass('is-invalid');
                    $('#name_error').text(errors.name[0]);
                } else {
                    $('#name').removeClass('is-invalid');
                    $('#name_error').text('');
                }

                // Email validation
                if (errors.email) {
                    $('#email').addClass('is-invalid');
                    $('#email_error').text(errors.email[0]);
                } else {
                    $('#email').removeClass('is-invalid');
                    $('#email_error').text('');
                }
            } else {
                toastr.error("Something went wrong. Please try again.");
                console.log(xhr.responseText);
            }
        }
    });
});


        </script>
    @endpush

</x-backend.dashboard>
