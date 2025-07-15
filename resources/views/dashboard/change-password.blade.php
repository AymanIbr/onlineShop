<x-backend.dashboard title="Change Admin Password">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Change Password</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form id="change-password-form">
                @csrf

                <div class="mb-3">
                    <label for="old_password" class="form-label">Old Password</label>
                    <input type="password" class="form-control" id="old_password" name="old_password">
                    <div id="old_password_error" class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password">
                    <div id="new_password_error" class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="new_password_confirmation"
                        name="new_password_confirmation">
                    <div id="new_password_confirmation_error" class="invalid-feedback"></div>
                </div>

                <button type="submit" id="submit-btn" class="btn btn-dark">
                    <i class="fas fa-key"></i> Change Password
                </button>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            $('#change-password-form').submit(function(e) {
                e.preventDefault();
                $('#submit-btn').prop('disabled', true);

                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.change-password') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        toastr.success(res.message);
                        $('#change-password-form')[0].reset();
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').text('');
                        $('#submit-btn').prop('disabled', false);
                    },
                    error: function(xhr) {
                        $('#submit-btn').prop('disabled', false);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            ['old_password', 'new_password', 'new_password_confirmation'].forEach(function(
                                field) {
                                if (errors[field]) {
                                    $('#' + field).addClass('is-invalid');
                                    $('#' + field + '_error').text(errors[field][0]);
                                } else {
                                    $('#' + field).removeClass('is-invalid');
                                    $('#' + field + '_error').text('');
                                }
                            });

                        } else {
                            toastr.error('Something went wrong. Please try again.');
                            console.log(xhr.responseText);
                        }
                    }
                });
            });
        </script>
    @endpush
</x-backend.dashboard>
