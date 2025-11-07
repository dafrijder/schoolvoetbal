<h1>Inloggen</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <label>E-mail:</label><br>
    <input type="email" name="email" value="{{ old('email') }}" required><br><br>

    <label>Wachtwoord:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Inloggen</button>
</form>
<p>Nog geen account? <a href="{{ route('register') }}">Registreren</a></p>
