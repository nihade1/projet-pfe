<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ArtisanMarket') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <style>
            body {
                background: linear-gradient(135deg, rgba(94, 53, 119, 0.1) 0%, rgba(244, 162, 97, 0.1) 100%);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            .auth-card {
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                max-width: 500px;
                width: 100%;
                margin: 2rem auto;
            }
            .auth-header {
                background: linear-gradient(135deg, #5e3577 0%, #8a4baf 100%);
                color: white;
                text-align: center;
                padding: 2rem 0;
            }
            .auth-logo {
                max-width: 200px;
                margin-bottom: 1rem;
            }
            .auth-body {
                padding: 2rem;
                background: white;
            }
        </style>
        
        <!-- Scripts -->
        @vite(['resources/js/app.js'])
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('index') }}">
                        <img src="{{ asset('images/logo.svg') }}" alt="ArtisanMarket Logo">
                    </a>
                </div>
            </nav>
        </header>

        <main class="flex-grow-1 d-flex align-items-center justify-content-center">
            <div class="container">
                <div class="auth-card">
                    <div class="auth-header">
                        <img src="{{ asset('images/logo.svg') }}" alt="ArtisanMarket" class="auth-logo">
                        <h4>Bienvenue sur ArtisanMarket</h4>
                    </div>
                    <div class="auth-body">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="container">
                <p class="text-center mb-0">&copy; {{ date('Y') }} ArtisanMarket - Tous droits réservés</p>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
