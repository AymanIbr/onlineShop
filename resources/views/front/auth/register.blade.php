<x-front.layout title="Register">
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('site.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Register</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-10">
            <div class="container">
                <div class="login-form">
                    <form id="registerForm" method="POST" action="{{ route('register') }}">
                        @csrf

                        <h4 class="modal-title">Register Now</h4>

                        <div class="form-group">
                            <input type="text" id="name" class="form-control" name="name" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <input type="email" id="email" class="form-control" name="email"
                                placeholder="Email">
                        </div>

                        <div class="form-group">
                            <input type="text" id="phone" name="phone" class="form-control"
                                placeholder="Phone">
                        </div>

                        <div class="form-group">
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="Password">
                        </div>

                        <div class="form-group">
                            <input type="password" id="password_confirmation" class="form-control"
                                name="password_confirmation" placeholder="Confirm Password">
                        </div>

                        <div class="form-group small">
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                        </div>

                        <button type="submit" id="signUp" class="btn btn-dark btn-block btn-lg">Register</button>
                    </form>

                    <div class="text-center small">
                        Already have an account? <a href="{{ route('login') }}">Login Now</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('js')
        <script>
            $(document).ready(function() {
                $('#registerForm').on('submit', function(e) {
                    e.preventDefault();

                    let name = $('#name').val().trim();
                    let email = $('#email').val().trim();
                    let phone = $('#phone').val().trim();
                    let password = $('#password').val().trim();
                    let confirmPassword = $('#password_confirmation').val().trim();

                    if (name === '' || email === '' || phone === '' || password === '' || confirmPassword ===
                        '') {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "All fields are required!"
                        });
                        return;
                    }

                    if (password !== confirmPassword) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Password confirmation does not match!"
                        });
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('register') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name: name,
                            email: email,
                            phone: phone,
                            password: password,
                            password_confirmation: confirmPassword
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Registration Successful!",
                                text: "You will be redirected shortly...",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '/';
                            });
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON?.errors;
                            let errorMessage = '';

                            if (errors) {
                                for (let field in errors) {
                                    errorMessage += errors[field][0] + '<br>';
                                }
                            } else {
                                errorMessage = 'An unexpected error occurred.';
                            }

                            Swal.fire({
                                icon: "error",
                                title: "Registration Failed",
                                html: errorMessage
                            });
                        }
                    });
                });
            });
        </script>
    @endpush

</x-front.layout>
