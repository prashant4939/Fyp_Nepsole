@extends('layouts.app')

@section('title', 'Edit Profile - NepSole')

@section('content')
<div class="settings-page">
    <div class="settings-container">

        @include('settings.partials.sidebar')

        <main class="settings-main">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="settings-card">
                <div class="settings-card-title">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profile
                </div>

                <form method="POST" action="{{ route('settings.update-profile') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Upload -->
                    <div class="avatar-upload">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="avatar-preview" id="avatarPreview">
                        @else
                            <div class="avatar-placeholder" id="avatarPlaceholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            <img src="" alt="Profile" class="avatar-preview" id="avatarPreview" style="display:none;">
                        @endif
                        <div class="avatar-upload-info">
                            <h4>Profile Photo</h4>
                            <p>JPG, PNG or WebP. Max 2MB.</p>
                            <label for="profile_image" class="avatar-upload-btn">Choose Photo</label>
                            <input type="file" id="profile_image" name="profile_image" accept="image/*" style="display:none;" onchange="previewImage(this)">
                        </div>
                    </div>
                    @error('profile_image')
                        <div class="form-error" style="margin-bottom:1rem;">{{ $message }}</div>
                    @enderror

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Full Name <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-input" value="{{ $user->email }}" readonly>
                            <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Email cannot be changed here.</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-input" placeholder="e.g. 9800000000" value="{{ old('phone', $user->phone) }}">
                            @error('phone') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-input" value="{{ ucfirst($user->role) }}" readonly>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-textarea" placeholder="Enter your full address">{{ old('address', $user->address) }}</textarea>
                            @error('address') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn-primary">Save Changes</button>
                        <a href="{{ route('settings.profile') }}" class="btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            const placeholder = document.getElementById('avatarPlaceholder');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@include('settings.partials.styles')
@endsection
