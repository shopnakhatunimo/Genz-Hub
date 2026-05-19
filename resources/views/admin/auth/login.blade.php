<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-xl p-8 shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6">Admin Login</h1>
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <input type="email" name="email" placeholder="Email" required class="input-field">
                <input type="password" name="password" placeholder="Password" required class="input-field">
                <button type="submit" class="w-full btn-primary">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
