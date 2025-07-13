<x-backend.dashboard title="Edit User">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Edit User</h1>
        <a class="btn btn-primary" href="{{ route('admin.users.index') }}">
            <i class="fas fa-long-arrow-alt-left"></i> All Users
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="update-form">
                @csrf
                <div class="mb-3">
                    @include('dashboard.users._form')
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update
                </button>
            </form>
        </div>
    </div>

    @push('js')
    <script>
        $('#update-form').submit(function(event) {
            event.preventDefault();

            let form = this;
            let formData = new FormData(form);
            formData.append('_method', 'put');
            formData.set('active', $('#active').is(':checked') ? 1 : 0);

            $.ajax({
                type: 'POST',
                url: '{{ route("admin.users.update", $user->id) }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message || 'User updated successfully');
                    window.location.href = "{{ route('admin.users.index') }}";
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        ['name','email','phone','address'].forEach(function(field) {
                            if(errors[field]) {
                                $('#' + field).addClass('is-invalid');
                                $('#' + field + '_error').text(errors[field][0]);
                            } else {
                                $('#' + field).removeClass('is-invalid');
                                $('#' + field + '_error').text('');
                            }
                        });
                    } else {
                        toastr.error("Something went wrong. Please try again.");
                        console.error(xhr.responseText);
                    }
                }
            });
        });
    </script>
    @endpush

</x-backend.dashboard>
