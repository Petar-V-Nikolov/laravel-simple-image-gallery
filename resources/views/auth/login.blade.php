@extends('layouts.app')

@section('title', 'Log in')

@section('content')
    <div class="form-card">
        <h1>Log in</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror

            <label class="checkbox">
                <input type="checkbox" name="remember"> Remember me
            </label>

            <button type="submit">Log in</button>
        </form>

        <p class="muted">Need an account? <a href="{{ route('register') }}">Register</a></p>
    </div>
@endsection
