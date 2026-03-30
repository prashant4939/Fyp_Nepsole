@extends('layouts.dashboard')

@section('title', 'Edit Profile')
@section('panel-name', ucfirst(auth()->user()->role) . ' Panel')
@section('page-title', 'Edit Profile')
@section('navbar-color', auth()->user()->role === 'admin' ? '#6366f1' : (auth()->user()->role === 'vendor' ? '#10b981' : '#f97316'))

@section('sidebar-nav')
@if(auth()->user()->role === 'admin')
    <div class="nav-section">
        <div class="nav-section-title">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <span class="nav-icon">📊</span>
            Dashboard
        </a>
    </div>
    <div class="nav-section">
        <div class="nav-section-title">Management</div>
        <a href="{{ route('admin.vendors.index') }}" class="nav-link">
            <span class="nav-icon">👥</span>
            Vendor Management
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link">
            <span class="nav-icon">📂</span>
            Categories
        </a>
        <a href="{{ route('admin.brands.index') }}" class="nav-link">
            <span class="nav-icon">🏷️</span>
            Brands
        </a>
    </div>
@elseif(auth()->user()->role === 'vendor')
    <div class="nav-section">
        <div class="nav-section-title">Main</div>
        <a href="{{ route('vendor.dashboard') }}" class="nav-link">
            <span class="nav-icon">📊</span>
            Dashboard
        </a>
    </div>
    <div class="nav-section">
        <div class="nav-section-title">Products</div>
        <a href="{{ route('vendor.products.index') }}" class="nav-link">
            <span class="nav-icon">🛍️</span>
            My Products
        </a>
        <a href="{{ route('vendor.products.create') }}" class="nav-link">
            <span class="nav-icon">➕</span>
            Add Product
        </a>
    </div>
    <div class="nav-section">
        <div class="nav-section-title">Browse</div>
        <a href="{{ route('vendor.categories') }}" class="nav-link">
            <span class="nav-icon">📂</span>
            Categories
        </a>
        <a href="{{ route('vendor.brands') }}" class="nav-link">
            <span class="nav-icon">🏷️</span>
            Brands
        </a>
    </div>
@else
    <div class="nav-section">
        <div class="nav-section-title">Main</div>
        <a href="{{ route('customer.dashboard') }}" class="nav-link">
            <span class="nav-icon">📊</span>
            Dashboard
        </a>
    </div>
@endif
@endsection

@section('content')
<div class="page-header">
    <h2>Edit Profile</h2>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="form-card">
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Full Name <span class="required">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email Address <span class="required">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Role</label>
            <input type="text" value="{{ ucfirst($user->role) }}" disabled>
            <small>Your role cannot be changed</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'vendor' ? route('vendor.dashboard') : route('customer.dashboard')) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
.page-header {
    margin-bottom: 2rem;
}

.page-header h2 {
    color: #1f2937;
    font-size: 24px;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.form-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    max-width: 600px;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    color: #374151;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.required {
    color: #ef4444;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-group input:focus {
    outline: none;
    border-color: #10b981;
}

.form-group input:disabled {
    background: #f9fafb;
    cursor: not-allowed;
}

.form-group small {
    display: block;
    color: #6b7280;
    font-size: 12px;
    margin-top: 0.25rem;
}

.error-message {
    color: #ef4444;
    font-size: 12px;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: #10b981;
    color: white;
}

.btn-primary:hover {
    background: #059669;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}
</style>
@endsection
