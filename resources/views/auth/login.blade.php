<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container">
        <!-- Left Section -->
        <div class="left">
            <h1>Halo, Selamat Datang Kembali</h1>
            <p>Hai, selamat datang di perpustakaan terbaik di Indonesia</p>

          <form method="POST" action="{{ route('loginProcess') }}">
            @csrf
            @if ($errors->any())
                <div style="color: red; margin-bottom: 10px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div style="color: green; margin-bottom: 10px;">
                    {{ session('success') }}
                </div>
            @endif

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Sign In</button>
        </form>

            <p class="register">
                Don’t have an account? 
                <a href="{{ route('registerAnggota') }}">Sign Up</a>
            </p>
        </div>

        <!-- Right Section (Image placeholder) -->
        <div class="right">
          <img src="{{ asset('img/Right.png') }}">
        </div>
    </div>
</body>
</html>
