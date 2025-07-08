<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Thank You - {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Fonts and Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('front-assets/css/style.css') . '?v=' . rand(111, 999) }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" />

    <style>
        /* تخصيص صفحة الشكر */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #ffffff 0%, #e1e8ed 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
            max-width: 620px;
            margin: 50px auto;
            background: #fff;
            box-shadow: 4px 8px 40px rgba(88, 146, 255, 0.15);
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
        }

        main h1 {
            font-family: 'Kaushan Script', cursive;
            font-size: 4.5rem;
            color: #5892FF;
            margin-bottom: 10px;
        }

        main p {
            font-size: 1.25rem;
            color: #555;
            margin-bottom: 20px;
        }

        main p strong {
            color: #2e52d9;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .btn-primary {
            background-color: #5892FF;
            border: none;
            padding: 12px 50px;
            font-size: 1.1rem;
            border-radius: 30px;
            color: #fff;
            box-shadow: 0 10px 16px rgba(174, 199, 251, 1);
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3d6df5;
            color: #fff;
        }

        footer {
            flex-shrink: 0;
            background-color: #222;
            color: #ccc;
            padding: 30px 15px;
            text-align: center;
            font-size: 0.9rem;
        }

        footer a {
            color: #5892FF;
            text-decoration: none;
            font-weight: 600;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            main {
                margin: 20px 15px;
                padding: 30px 20px;
            }

            main h1 {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="bg-dark" style="padding: 15px 0;">
        <div class="container"
            style="max-width: 1140px; margin: auto; display: flex; align-items: center; justify-content: space-between;">
            <a href="{{ route('site.index') }}" style="text-decoration:none; display:flex; align-items:center;">
                <span
                    style="font-size: 2rem; font-weight: 700; color: #5892FF; background-color: #222; padding: 5px 15px;">Online</span>
                <span
                    style="font-size: 2rem; font-weight: 700; color: #fff; background-color: #5892FF; padding: 5px 15px; margin-left: -5px;">SHOP</span>
            </a>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <h1>Thank You!</h1>
        <p>Your order has been placed successfully.</p>
        @isset($order)
            <p>Your order number is <strong>#{{ $order->number }}</strong></p>
        @endisset
        <a href="{{ route('site.index') }}" class="btn-primary">Go Home</a>
    </main>

    <!-- FOOTER -->
    <footer>
        <p>Need help? <a href="mailto:support@example.com">Contact us</a></p>
        <p>© {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
    </footer>

</body>

</html>
