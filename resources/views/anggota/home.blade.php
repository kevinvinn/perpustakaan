<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Anggota</title>
</head>
<body>
    <h1>Halo, {{ Auth::user()->nama }}</h1>
    <p>Anda login sebagai <strong>{{ Auth::user()->role }}</strong>.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
