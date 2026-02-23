@extends('layouts.auth')

@section('title', 'Registration - NepSole')

@section('content')
<div class="auth-title">Registration</div>

<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="form-group">
        <label class="form-label">Full Name</label>
        <input 
            type="text" 
            name="name" 
            class="form-input" 
            placeholder="Enter your full name"
            value="{{ old('name') }}"
            required
        >
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

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
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="">Select your role</option>
            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
        </select>
        @error('role')
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

    <div class="form-group">
        <label class="form-label">Confirm Password</label>
        <input 
            type="password" 
            name="password_confirmation" 
            class="form-input" 
            placeholder="Confirm your password"
            required
        >
    </div>

    <button type="submit" class="btn-primary">Register</button>
</form>

<div class="auth-footer">
    Already have an account? <a href="{{ route('login') }}">Login here</a>
</div>
@endsection
