@extends('layouts.auth')

@section('title', 'Forgot Password - NepSole')

@section('content')
<div class="auth-title">Forgot Password</div>

@if (session('status'))
    <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
        {{ session('status') }}
    </div>
@endif

<p style="text-align: center; color: #6b7280; font-size: 14px; margin-bottom: 24px;">
    Enter your email address and we'll send you a link to reset your password.
</p>

<form method="POST" action="{{ route('password.email') }}">
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

    <button type="submit" class="btn-primary">Send Reset Link</button>
</form>

<div class="auth-footer">
    Remember your password? <a href="{{ route('login') }}">Login here</a>
</div>
@endsection
