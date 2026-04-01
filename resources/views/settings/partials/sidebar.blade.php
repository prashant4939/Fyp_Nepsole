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
                Back to Dashboard
            </a>
        @elseif(auth()->user()->role === 'vendor')
            <a href="{{ route('vendor.dashboard') }}" class="sidebar-link">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Back to Dashboard
            </a>
        @endif
    </nav>
</aside>
