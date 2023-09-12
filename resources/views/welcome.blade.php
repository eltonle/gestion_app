<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
      html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}



body {
    position: relative;
    font-family: Arial, sans-serif;
}

body::before {
    content: "";
    background-color: rgba(0, 0, 0, 0.3); /* Couleur sombre avec opacité (0.5 pour 50%) */
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1; /* Place le pseudo-élément derrière le contenu du body */
}

        body::after {
            content: "";
            background-image: url('{{ asset('tof.JPG') }}');
            background-size: cover;
            background-position: center;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2; /* Place l'image de fond derrière le pseudo-élément sombre */
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .welcome-message {
            font-size: 44px;
            color: white;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .buttons {
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
        </style>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="welcome-message">
            Bienvenue dans l'application de gestion de pressing
        </div>
        <div class="buttons">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                    <!-- <a href="{{ url('/home') }}" class="text-lg text-gray-700 dark:text-gray-500 underline">Home</a> -->
                    <a href="{{ url('/home') }}"><button class="btn">Home</button></a>
                    @else
                    <!-- <a href="{{ route('login') }}" class="text-lg text-gray-700 dark:text-gray-500 underline">Log in</a> -->
                    <a href="{{ route('login') }}"><button class="btn">Se Connecter</button></a>
                    @if (Route::has('register'))
                    <!-- <a href="{{ route('register') }}"
                        class="ml-4 text-lg text-gray-700 dark:text-gray-500 underline">Register</a> -->
                        <!-- <a href="{{ route('register') }}"><button class="btn">Register</button></a> -->
                    @endif
                    @endauth
                </div>
            @endif
            <!-- <a href="register.html"><button class="btn">Register</button></a>
            <a href="login.html"><button class="btn">Login</button></a> -->
        </div>
    </div>
</body>
<!-- <body class="antialiased">
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-100 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
            <a href="{{ url('/home') }}" class="text-lg text-gray-700 dark:text-gray-500 underline">Home</a>
            @else
            <a href="{{ route('login') }}" class="text-lg text-gray-700 dark:text-gray-500 underline">Log in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="ml-4 text-lg text-gray-700 dark:text-gray-500 underline">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1>Welcome</h1>
        </div>
    </div>
</body> -->

</html>