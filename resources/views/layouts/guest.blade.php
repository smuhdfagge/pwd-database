<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'V-PeSDI PLWDs Database') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="{{ asset('images/vpesdilogo.jpg') }}">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Custom CSS -->
        <style>
            :root {
                --primary-green: #28a745;
                --dark-bg: #212529;
            }
            
            body {
                font-family: 'Figtree', sans-serif;
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                min-height: 100vh;
            }
            
            .auth-card {
                border-radius: 15px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }
            
            .auth-brand {
                background: linear-gradient(135deg, var(--dark-bg) 0%, var(--primary-green) 100%);
                color: white;
            }
            
            .btn-primary {
                background-color: var(--primary-green);
                border-color: var(--primary-green);
            }
            
            .btn-primary:hover {
                background-color: #218838;
                border-color: #1e7e34;
            }
            
            .text-primary {
                color: var(--primary-green) !important;
            }
            
            .form-control:focus {
                border-color: var(--primary-green);
                box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
            }
            
            .benefit-item {
                transition: transform 0.2s;
            }
            
            .benefit-item:hover {
                transform: translateX(5px);
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container-fluid">
            <div class="row min-vh-100 align-items-center justify-content-center py-5">
                <div class="col-12 col-lg-10 col-xl-8">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
