<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tambahkan CSS Anda di sini -->
    <style>
        body { font-family: sans-serif; margin: 0; background-color: #f9f9f9; }
        header { background-color: #333; color: white; padding: 1em 0; }
        nav { max-width: 1000px; margin: auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        nav a, nav form button { color: white; text-decoration: none; margin-left: 15px; background: none; border: none; cursor: pointer; font-size: 1em; }
        nav a:hover, nav form button:hover { text-decoration: underline; }
        .main-content { max-width: 1000px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        h1, h2, h3 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .button, button { background-color: #3490dc; color: white; padding: 8px 12px; text-decoration:none; border: none; border-radius: 4px; cursor: pointer; display: inline-block; margin-top: 5px; }
        .button-green { background-color: #38c172; } .button-red { background-color: #e3342f; }
        .button:hover, button:hover { opacity: 0.9; }
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
        .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .alert-info { color: #0c5460; background-color: #d1ecf1; border-color: #bee5eb; }
        .alert-warning { color: #856404; background-color: #fff3cd; border-color: #ffeeba; }
        .error-message { color: red; font-size: 0.9em; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"], input[type="time"], input[type="number"], select, textarea {
            width: calc(100% - 22px); padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;
        }
        .pagination { margin-top: 20px; }
        .pagination li { display: inline; margin-right: 5px; }
        .pagination li a, .pagination li span { padding: 5px 10px; text-decoration: none; border: 1px solid #ddd; }
        .pagination li.active span { background-color: #3490dc; color: white; border-color: #3490dc; }
    </style>
</head>
<body>
    <header>
        @include('partials.navigation')
    </header>

    <main class="main-content">
        @if(View::hasSection('header'))
            <h2>@yield('header')</h2>
            <hr>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
        @if (session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        @yield('content')
    </main>

    <!-- Tambahkan JS Anda di sini jika perlu -->
</body>
</html>
