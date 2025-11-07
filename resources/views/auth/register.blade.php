<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
</head>
<body>
    <h1>Maak een account aan</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label>Naam:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required><br><br>

        <label>E-mailadres:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Wachtwoord:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Bevestig wachtwoord:</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Registreer</button>
    </form>
</body>
</html>
