@extends('layouts.auth')

@section('title', 'Login - NepSole')

@section('content')
<div class="auth-title">Login</div>

@if (session('status'))
    <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="form-group">
        <label class="form-label">Email</label>
        <input 
            type="email" 
            name="email" 
            class="form-input" 
            placeholder="Enter your email"
            value="{{ old('email') }}"
            required
        >
        @error('email')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label">Password</label>
        <input 
            type="password" 
            name="password" 
            class="form-input" 
            placeholder="Enter your password"
            required
        >
        @error('password')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div style="text-align: right; margin-bottom: 16px;">
        <a href="{{ route('password.request') }}" style="color: #6366f1; text-decoration: none; font-size: 14px; font-weight: 500;">
            Forgot Password?
        </a>
    </div>

    <button type="submit" class="btn-primary">Login</button>
</form>

<div class="auth-footer">
    Don't have an account? <a href="{{ route('register') }}">Register here</a>
</div>
@endsection
