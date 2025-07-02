<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Login to your dashboard account to manage your profile, settings, and content.">
    <meta name="keywords" content="login, dashboard, admin, panel, user access">

    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #f2f4f7;
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .flex-div {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }

        .name-content {
            margin-right: 7rem;
        }

        .name-content .logo {
            font-size: 3.5rem;
            color: #1877f2;
        }

        .name-content p {
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            background: #fff;
            padding: 2rem;
            width: 530px;
            height: 380px;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgb(0 0 0 / 10%), 0 8px 16px rgb(0 0 0 / 10%);
        }

        form input {
            outline: none;
            padding: 0.8rem 1rem;
            margin-bottom: 0.8rem;
            font-size: 1.1rem;
        }

        form input:focus {
            border: 1.8px solid #1877f2;
        }

        form .login {
            outline: none;
            border: none;
            background: #1877f2;
            padding: 0.8rem 1rem;
            border-radius: 0.4rem;
            font-size: 1.1rem;
            color: #fff;
        }

        form .head {
            text-align: center !important;
            margin-bottom: 1rem !important;
            color: #1877f2 !important;
        }


        form .login:hover {
            background: #0f71f1;
            cursor: pointer;
        }

        form a {
            text-decoration: none;
            text-align: center;
            font-size: 1rem;
            padding-top: 0.8rem;
            color: #1877f2;
        }

        form hr {
            background: #f7f7f7;
            margin: 1rem;
        }


        /* //.........Media Query.........// */

        @media (max-width: 500px) {
            html {
                font-size: 60%;
            }

            .name-content {
                margin: 0;
                text-align: center;
            }

            form {
                width: 300px;
                height: fit-content;
            }

            form input {
                margin-bottom: 1rem;
                font-size: 1.5rem;
            }

            form .login {
                font-size: 1.5rem;
            }

            form a {
                font-size: 1.5rem;
            }

            form .create-account {
                font-size: 1.5rem;
            }

            .flex-div {
                display: flex;
                flex-direction: column;
            }
        }

        @media (min-width: 501px) and (max-width: 768px) {
            html {
                font-size: 60%;
            }

            .name-content {
                margin: 0;
                text-align: center;
            }

            form {
                width: 300px;
                height: fit-content;
            }

            form input {
                margin-bottom: 1rem;
                font-size: 1.5rem;
            }

            form .login {
                font-size: 1.5rem;
            }

            form a {
                font-size: 1.5rem;
            }

            form .create-account {
                font-size: 1.5rem;
            }

            .flex-div {
                display: flex;
                flex-direction: column;
            }
        }

        @media (min-width: 769px) and (max-width: 1200px) {
            html {
                font-size: 60%;
            }

            .name-content {
                margin: 0;
                text-align: center;
            }

            form {
                width: 300px;
                height: fit-content;
            }

            form input {
                margin-bottom: 1rem;
                font-size: 1.5rem;
            }

            form .login {
                font-size: 1.5rem;
            }

            form a {
                font-size: 1.5rem;
            }

            form .create-account {
                font-size: 1.5rem;
            }

            .flex-div {
                display: flex;
                flex-direction: column;
            }

            @media (orientation: landscape) and (max-height: 500px) {
                .header {
                    height: 90vmax;
                }
            }
        }
    </style>

</head>

<body>
    <div class="content">
        <div class="flex-div">
            <div class="name-content">
                <h1 class="logo">Dashboard Login</h1>
                <p>Manage your content and settings from one place.</p>
            </div>

            {{-- <form method="POST" action="{{ route('login') }}"> --}}
            <form id="login-form">
                <h1 class="head">Welcome Back!</h1>
                <label for="email">Email or Phone Number</label>
                <input id="email" type="text" name="email" value="{{ old('email') }}"
                    placeholder="Email or Phone Number" autofocus>

                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Password">

                <button class="login">Log In</button>
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            axios.post('{{ route('login') }}', {
                    email: email,
                    password: password
                })
                .then(function(response) {
                    toastr.success('Login Successful!');
                    window.location.href = "/admin/dashboard";
                })
                .catch(function(error) {
                    if (error.response && error.response.status === 422) {
                        toastr.error(error.response.data.message || "Invalid credentials.");
                    } else {
                        toastr.error("Something went wrong. Please try again.");
                    }
                });
        });
    </script>



</body>

</html>
