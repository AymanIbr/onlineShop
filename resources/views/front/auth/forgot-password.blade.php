<x-front.layout title="Forgot Password">
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('site.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Forgot Password</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-10">
            <div class="container">
                <div class="login-form">
                    <form id="forgotPasswordForm">
                        @csrf
                        <h4 class="modal-title">Reset Your Password</h4>

                        <div class="form-group">
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Enter your email address" autofocus>
                            <div id="email_error" class="invalid-feedback"></div>

                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-dark btn-block btn-lg">
                            Send Reset Link
                        </button>
                    </form>

                    <div class="text-center small mt-3">
                        Remember your password? <a href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

   @push('js')
<script>
    $(document).ready(function() {
        $('#forgotPasswordForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $("#submitBtn").prop("disabled", true);

            $.ajax({
                url: '{{ route('password.email') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#submitBtn").prop("disabled", false);
                    toastr.success(response.message || 'Password reset link sent to your email.');
                    $('#forgotPasswordForm')[0].reset();
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').text('');
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

                    } else {
                        toastr.error("Something went wrong. Please try again.");
                        console.log(xhr.responseText);
                    }
                }
            });
        });
    });
</script>
@endpush

</x-front.layout>
