@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="form-card">
        <h1>Register</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required minlength="8">
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8">

            <button type="submit">Create account</button>
        </form>

        <p class="muted">Already registered? <a href="{{ route('login') }}">Log in</a></p>
    </div>
@endsection
