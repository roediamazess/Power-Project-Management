<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background: #0b1220; color: #e5e7eb; }
        .card { max-width: 420px; width: 100%; background: #111827; border: 1px solid #1f2937; }
        .card-header, .btn-primary { background: #2563eb; border-color: #2563eb; }
        a { color:#93c5fd; }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const form = document.getElementById('login-form');
            form.addEventListener('submit', function () {
                form.querySelector('button[type="submit"]').disabled = true;
            });
        });
    </script>
</head>
<body>
<div class="card shadow-sm p-3">
    <h4 class="mb-3 text-center">Sign in</h4>
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
    <form id="login-form" method="POST" action="/login">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email','admin@example.com') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" value="admin12345" required>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="remember" name="remember" checked>
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <button class="btn btn-primary w-100" type="submit">Login</button>
    </form>
    <div class="mt-3 text-center">
        <a href="/">Kembali</a>
    </div>
 </div>
</body>
</html>




