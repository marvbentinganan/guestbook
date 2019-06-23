<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        }

        .full-height {
        height: 100vh;
        }
        
        .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
        }
        
        .position-ref {
        position: relative;
        }
    </style>
    @yield('page_styles')
</head>

<body>
    <div id="app" class="full-height position-ref">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @routes
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('page_scripts')
</body>

</html>