<x-front.layout title="Reset Password">
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('site.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Reset Password</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-10">
            <div class="container">
                <div class="login-form">
                    <form id="resetPasswordForm">
                        @csrf
                        <input type="hidden" name="token" value="{{ request()->route('token') }}">

                        <h4 class="modal-title">Reset Your Password</h4>

                        <div class="form-group">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                value="{{ request()->get('email') }}">
                            <div class="invalid-feedback d-block" id="email_error"></div>
                        </div>

                        <div class="form-group">
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="New Password">
                            <div class="invalid-feedback d-block" id="password_error"></div>
                        </div>

                        <div class="form-group">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" placeholder="Confirm Password">
                            <div class="invalid-feedback d-block" id="password_confirmation_error"></div>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-dark btn-block btn-lg">
                            Reset Password
                        </button>
                    </form>

                    <div class="text-center small mt-3">
                        <a href="{{ route('login') }}">Back to Login</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('js')
        <script>
            $('#resetPasswordForm').submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                $("#submitBtn").prop("disabled", true);

                $.ajax({
                    url: '{{ url('/reset-password') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#submitBtn").prop("disabled", false);
                        toastr.success(response.message || 'Password has been reset successfully.');
                        $('#resetPasswordForm')[0].reset();
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').text('');

                        window.location.href = "{{ route('login') }}";
                    },
                    error: function(xhr) {
                        $("#submitBtn").prop("disabled", false);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.email) {
                                $('#email').addClass('is-invalid');
                                $('#email_error').text(errors.email[0]);
                            } else {
                                $('#email').removeClass('is-invalid');
                                $('#email_error').text('');
                            }

                            if (errors.password) {
                                $('#password').addClass('is-invalid');
                                $('#password_error').text(errors.password[0]);
                            } else {
                                $('#password').removeClass('is-invalid');
                                $('#password_error').text('');
                            }

                            if (errors.password_confirmation) {
                                $('#password_confirmation').addClass('is-invalid');
                                $('#password_confirmation_error').text(errors.password_confirmation[0]);
                            } else {
                                $('#password_confirmation').removeClass('is-invalid');
                                $('#password_confirmation_error').text('');
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
</x-front.layout>
