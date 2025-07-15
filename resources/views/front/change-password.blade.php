<x-front.layout>
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('profile') }}">My Account</a></li>
                        <li class="breadcrumb-item">Change password</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class=" section-11 ">
            <div class="container  mt-5">
                <div class="row">
                    <div class="col-md-3">
                        @include('front.parts.sidebar')
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                            </div>
                            <div class="card-body p-4">
                                <div class="row">
                                    <form id="change-password-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="old_password">Old Password</label>
                                            <input type="password" name="old_password" id="old_password"
                                                class="form-control">
                                            <div id="old_password_error" class="invalid-feedback"></div>

                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password">New Password</label>
                                            <input type="password" name="new_password" id="new_password"
                                                class="form-control">
                                            <div id="new_password_error" class="invalid-feedback"></div>

                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password_confirmation">Confirm Password</label>
                                            <input type="password" name="new_password_confirmation"
                                                id="new_password_confirmation" class="form-control">
                                            <div id="new_password_confirmation_error" class="invalid-feedback"></div>

                                        </div>
                                        <div class="d-flex">
                                            <button id="submit" name="submit" type="submit"
                                                class="btn btn-dark">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('js')
        <script>
            $('#change-password-form').submit(function(event) {
                event.preventDefault();

                let formData = new FormData(this);
                $("#submit").prop("disabled", true);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('change-password') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#submit").prop("disabled", false);
                        toastr.success(response.message || 'Password updated successfully');
                        $('#change-password-form')[0].reset();
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').text('');
                    },
                    error: function(xhr) {
                         $("#submit").prop("disabled", false);
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.old_password) {
                                $('#old_password').addClass('is-invalid');
                                $('#old_password_error').text(errors.old_password[0]);
                            } else {
                                $('#old_password').removeClass('is-invalid');
                                $('#old_password_error').text('');
                            }

                            if (errors.new_password) {
                                $('#new_password').addClass('is-invalid');
                                $('#new_password_error').text(errors.new_password[0]);
                            } else {
                                $('#new_password').removeClass('is-invalid');
                                $('#new_password_error').text('');
                            }

                            if (errors.new_password_confirmation) {
                                $('#new_password_confirmation').addClass('is-invalid');
                                $('#new_password_confirmation_error').text(errors.new_password_confirmation[
                                    0]);
                            } else {
                                $('#new_password_confirmation').removeClass('is-invalid');
                                $('#new_password_confirmation_error').text('');
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
