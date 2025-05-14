<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Guest</title>
    <!-- Tambahkan CSS Anda di sini -->
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2 { text-align: center; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], input[type="password"], select, textarea {
            width: calc(100% - 22px); padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;
        }
        button { background-color: #3490dc; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #2779bd; }
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
        .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .error-message { color: red; font-size: 0.9em; margin-top: -10px; margin-bottom: 10px; }
        .text-center { text-align: center; }
        .mt-1 { margin-top: 0.25rem; } .mt-2 { margin-top: 0.5rem; } .mt-3 { margin-top: 1rem; }
        .mb-1 { margin-bottom: 0.25rem; } .mb-2 { margin-bottom: 0.5rem; } .mb-3 { margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>