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

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>

                <!-- <div class="options">
                    <label>
                        <input type="checkbox" name="#"> Remember me
                    </label>
                    <a href="#">Forgot Password?</a>
                </div> -->

                <button type="submit" class="btn">Sign In</button>
            </form>

            <p class="register">
                Don’t have an account? 
                <a href="{{ route('register') }}">Sign Up</a>
            </p>
        </div>

        <!-- Right Section (Image placeholder) -->
        <div class="right">
          <img src="{{ asset('img/Right.png') }}">
        </div>
    </div>
</body>
</html>
