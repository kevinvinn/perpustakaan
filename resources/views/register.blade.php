<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Perpustakaan</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <h1>Daftar Akun Baru</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <!-- <select name="role" required>
            <option value="anggota">Anggota</option>
            <option value="petugas">Petugas</option>
            <option value="admin">Admin</option>
        </select> -->

        <button type="submit">Register</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('loginPage') }}">Login di sini</a></p>
</body>
</html>
