<x-front.layout title="Login">
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('site.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Login</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class=" section-10">
            <div class="container">
                <div class="login-form">
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf
                        <h4 class="modal-title">Login to Your Account</h4>

                        <div class="form-group">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                required autofocus>
                        </div>

                        <div class="form-group">
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Password" required>
                        </div>

                        <div class="form-group small">
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                        </div>

                        <button type="submit" id="loginBtn" class="btn btn-dark btn-block btn-lg">Login</button>
                    </form>

                    <div class="text-center small">
                        Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('js')
        <script>
            $(document).ready(function() {
                $('#loginBtn').on('click', function(e) {
                    e.preventDefault();

                    let email = $('#email').val().trim();
                    let password = $('#password').val().trim();

                    if (email === '' || password === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'All fields are required!'
                        });
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('login') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            email: email,
                            password: password,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Successful!',
                                text: 'Redirecting...',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('site.index') }}";

                            });
                        },
                       error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';

                        if (errors) {
                            for (let field in errors) {
                                errorMessage += errors[field][0] + '<br>';
                            }
                        } else if (xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else {
                            errorMessage = 'An unexpected error occurred.';
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            html: errorMessage
                        });
                    }

                    });
                });
            });
        </script>
    @endpush
</x-front.layout>
