@extends('layouts.app')

@section('content')
<div class="settings-page">
    <div class="settings-container">

        <!-- Sidebar -->
        <aside class="settings-sidebar">
            <div class="sidebar-user">
                @if(auth()->user()->profile_image)
                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" class="sidebar-avatar">
                @else
                    <div class="sidebar-avatar-placeholder">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="sidebar-user-info">
                    <div class="sidebar-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('settings.profile') }}"
                   class="sidebar-link {{ request()->routeIs('settings.profile') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    View Profile
                </a>
                <a href="{{ route('settings.edit-profile') }}"
                   class="sidebar-link {{ request()->routeIs('settings.edit-profile') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profile
                </a>
                <a href="{{ route('settings.change-password') }}"
                   class="sidebar-link {{ request()->routeIs('settings.change-password') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Change Password
                </a>
                <div class="sidebar-divider"></div>
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('customer.dashboard') }}" class="sidebar-link">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                @elseif(auth()->user()->role === 'vendor')
                    <a href="{{ route('vendor.dashboard') }}" class="sidebar-link">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="settings-main">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @yield('settings-content')
        </main>
    </div>
</div>

<style>
.settings-page {
    background: #f3f4f6;
    min-height: calc(100vh - 130px);
    padding: 2rem 0;
}

.settings-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 2rem;
    align-items: start;
}

/* Sidebar */
.settings-sidebar {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    position: sticky;
    top: 1.5rem;
}

.sidebar-user {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    padding: 1.75rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.sidebar-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.4);
    flex-shrink: 0;
}

.sidebar-avatar-placeholder {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: rgba(255,255,255,0.25);
    border: 3px solid rgba(255,255,255,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 700;
    color: white;
    flex-shrink: 0;
}

.sidebar-name {
    font-weight: 700;
    color: white;
    font-size: 15px;
}

.sidebar-role {
    font-size: 12px;
    color: rgba(255,255,255,0.75);
    margin-top: 2px;
    text-transform: capitalize;
}

.sidebar-nav {
    padding: 0.75rem 0;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.5rem;
    color: #4b5563;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
}

.sidebar-link:hover {
    background: #f3f4f6;
    color: #6366f1;
}

.sidebar-link.active {
    background: #eef2ff;
    color: #6366f1;
    border-right: 3px solid #6366f1;
    font-weight: 600;
}

.sidebar-divider {
    height: 1px;
    background: #e5e7eb;
    margin: 0.5rem 1.5rem;
}

/* Main */
.settings-main {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.settings-card {
    background: white;
    border-radius: 14px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}

.settings-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 1.75rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.settings-card-title svg {
    color: #6366f1;
}

/* Form */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-input, .form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    color: #111827;
    background: #f9fafb;
    transition: all 0.2s;
    font-family: inherit;
}

.form-input:focus, .form-textarea:focus {
    outline: none;
    border-color: #6366f1;
    background: white;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}

.form-input[readonly] {
    background: #f3f4f6;
    color: #6b7280;
    cursor: not-allowed;
}

.form-textarea {
    resize: vertical;
    min-height: 90px;
}

.form-error {
    color: #ef4444;
    font-size: 12px;
    margin-top: 4px;
}

/* Buttons */
.btn-primary {
    padding: 0.75rem 2rem;
    background: #6366f1;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #4f46e5;
    transform: translateY(-1px);
}

.btn-secondary {
    padding: 0.75rem 1.5rem;
    background: white;
    color: #374151;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s;
}

.btn-secondary:hover {
    border-color: #6366f1;
    color: #6366f1;
}

.btn-group {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

/* Alert */
.alert {
    padding: 1rem 1.25rem;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 14px;
    font-weight: 500;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
}

/* Profile Info */
.profile-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}

.info-item {
    padding: 1rem 1.25rem;
    background: #f9fafb;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-label {
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.35rem;
}

.info-value {
    font-size: 15px;
    font-weight: 500;
    color: #111827;
}

.info-value.empty {
    color: #9ca3af;
    font-style: italic;
    font-weight: 400;
}

/* Avatar Upload */
.avatar-upload {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    padding: 1.25rem;
    background: #f9fafb;
    border-radius: 10px;
    border: 1.5px dashed #d1d5db;
}

.avatar-preview {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e5e7eb;
    flex-shrink: 0;
}

.avatar-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 700;
    color: white;
    flex-shrink: 0;
}

.avatar-upload-info h4 {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.25rem;
}

.avatar-upload-info p {
    font-size: 12px;
    color: #9ca3af;
    margin-bottom: 0.75rem;
}

.avatar-upload-btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: white;
    border: 1.5px solid #6366f1;
    color: #6366f1;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.avatar-upload-btn:hover {
    background: #6366f1;
    color: white;
}

/* Password strength */
.password-strength {
    margin-top: 6px;
    height: 4px;
    border-radius: 2px;
    background: #e5e7eb;
    overflow: hidden;
}

.password-strength-bar {
    height: 100%;
    border-radius: 2px;
    transition: all 0.3s;
    width: 0%;
}

@media (max-width: 768px) {
    .settings-container {
        grid-template-columns: 1fr;
    }

    .settings-sidebar {
        position: static;
    }

    .form-row, .profile-info-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
