<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Perpustakaan</title>
</head>
<body>
    <h1>Daftar Akun Baru</h1>

    {{-- Menampilkan error validasi --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('registerProcess') }}">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">

        <input type="text" name="nama" placeholder="Nama" value="{{ old('nama') }}" required>
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Register</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
</body>
</html>
