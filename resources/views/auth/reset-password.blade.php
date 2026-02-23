@extends('layouts.auth')

@section('title', 'Reset Password - NepSole')

@section('content')
<div class="auth-title">Reset Password</div>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">
    
    <div class="form-group">
        <label class="form-label">Email</label>
        <input 
            type="email" 
            class="form-input" 
            value="{{ $email }}"
            readonly
            style="background: #f3f4f6; cursor: not-allowed;"
        >
        @error('email')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label">New Password</label>
        <input 
            type="password" 
            name="password" 
            class="form-input" 
            placeholder="Enter new password"
            required
        >
        @error('password')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label">Confirm Password</label>
        <input 
            type="password" 
            name="password_confirmation" 
            class="form-input" 
            placeholder="Confirm new password"
            required
        >
    </div>

    <button type="submit" class="btn-primary">Reset Password</button>
</form>

<div class="auth-footer">
    Remember your password? <a href="{{ route('login') }}">Login here</a>
</div>

<style>
    .warning-box {
        background: #fef3c7;
        color: #92400e;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13px;
        text-align: center;
        font-weight: 500;
    }
</style>

<div class="warning-box">
    ⚠️ This reset link expires in 40 seconds!
</div>
@endsection
