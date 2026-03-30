@extends('layouts.dashboard')

@section('title', 'Add Brand - Admin')
@section('panel-name', 'Admin Panel')
@section('page-title', 'Add New Brand')
@section('navbar-color', '#6366f1')

@section('sidebar-nav')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <h2>Add New Brand</h2>
    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">← Back to Brands</a>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="name">Brand Name <span class="required">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="logo">Brand Logo</label>
            <div id="imagePreview" style="display: none; margin-bottom: 1rem;">
                <img id="preview" src="" alt="Preview" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                <p style="font-size: 12px; color: #6b7280; margin-top: 0.5rem;">Image Preview</p>
            </div>
            <input type="file" id="logo" name="logo" accept="image/*" onchange="previewImage(event)">
            <small>Accepted formats: JPG, JPEG, PNG (Max: 2MB)</small>
            @error('logo')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create Brand</button>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-header h2 {
    color: #1f2937;
    font-size: 24px;
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
    background: #6366f1;
    color: white;
}

.btn-primary:hover {
    background: #4f46e5;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

.form-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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

.form-group input[type="text"],
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: #6366f1;
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
</style>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection