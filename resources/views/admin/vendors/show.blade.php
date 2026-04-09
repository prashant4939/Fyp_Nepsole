@extends('layouts.dashboard')

@section('title', 'Vendor Details - ' . $vendor->business_name)
@section('panel-name', 'Admin Panel')
@section('page-title', 'Vendor Details')
@section('navbar-color', '#6366f1')

@section('sidebar-nav')
@include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
    .back-link { display:inline-block; color:#6366f1; text-decoration:none; font-weight:500; font-size:14px; margin-bottom:1.25rem; }
    .back-link:hover { text-decoration:underline; }

    .vr-card { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden; margin-bottom:1.5rem; }
    .vr-card-header { background:#f9fafb; padding:1.25rem 1.5rem; border-bottom:1px solid #e5e7eb; font-size:16px; font-weight:600; color:#111827; }
    .vr-card-body { padding:1.5rem; }

    .info-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:1.25rem; }
    .info-item .label { font-size:12px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px; }
    .info-item .value { font-size:15px; color:#111827; font-weight:500; }

    .badge { display:inline-flex; align-items:center; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; text-transform:uppercase; }
    .badge-pending  { background:#fef3c7; color:#92400e; }
    .badge-approved, .badge-active { background:#d1fae5; color:#065f46; }
    .badge-inactive { background:#f3f4f6; color:#6b7280; }
    .badge-rejected { background:#fee2e2; color:#991b1b; }

    .doc-item { display:flex; justify-content:space-between; align-items:center; padding:0.875rem 1rem; background:#f9fafb; border-radius:8px; margin-bottom:0.5rem; }
    .doc-name { font-size:14px; font-weight:500; color:#374151; }
    .doc-link { color:#6366f1; text-decoration:none; font-weight:600; font-size:13px; padding:6px 14px; background:#e0e7ff; border-radius:6px; transition:background 0.2s; }
    .doc-link:hover { background:#c7d2fe; }
    .doc-missing { font-size:13px; color:#9ca3af; font-style:italic; }

    .deactivation-note { background:#fef3c7; border:1px solid #fbbf24; border-radius:8px; padding:1rem; margin-top:1rem; }
    .deactivation-note h4 { color:#92400e; margin-bottom:0.5rem; font-size:14px; }
    .deactivation-note p  { color:#92400e; font-size:14px; }

    .action-row { display:flex; gap:1rem; flex-wrap:wrap; }
    .btn { padding:0.65rem 1.5rem; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; display:inline-block; }
    .btn-approve    { background:#10b981; color:#fff; }
    .btn-approve:hover { background:#059669; }
    .btn-reject     { background:#ef4444; color:#fff; }
    .btn-reject:hover  { background:#dc2626; }
    .btn-deactivate { background:#f59e0b; color:#fff; }
    .btn-deactivate:hover { background:#d97706; }
    .btn-reactivate { background:#3b82f6; color:#fff; }
    .btn-reactivate:hover { background:#2563eb; }
</style>
@endpush

@section('content')

<a href="{{ route('admin.vendors.index') }}" class="back-link">← Back to Vendor Management</a>

@if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:0.875rem 1.25rem;border-radius:10px;margin-bottom:1.25rem;font-size:14px;font-weight:500;">
        ✅ {{ session('success') }}
    </div>
@endif

{{-- Basic Information --}}
<div class="vr-card">
    <div class="vr-card-header">Basic Information</div>
    <div class="vr-card-body">
        <div class="info-grid">
            <div class="info-item">
                <div class="label">Vendor Name</div>
                <div class="value">{{ $vendor->user->name }}</div>
            </div>
            <div class="info-item">
                <div class="label">Email Address</div>
                <div class="value">{{ $vendor->user->email }}</div>
            </div>
            <div class="info-item">
                <div class="label">Business Name</div>
                <div class="value">{{ $vendor->business_name }}</div>
            </div>
            <div class="info-item">
                <div class="label">PAN Number</div>
                <div class="value">{{ $vendor->pan_number ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="label">Business Type</div>
                <div class="value">{{ $vendor->getBusinessTypeLabel() }}</div>
            </div>
            <div class="info-item">
                <div class="label">Application Date</div>
                <div class="value">{{ $vendor->created_at->format('M d, Y h:i A') }}</div>
            </div>
            <div class="info-item">
                <div class="label">Status</div>
                <div class="value">
                    @if(!$vendor->is_verified)
                        <span class="badge badge-pending">Pending Approval</span>
                    @elseif($vendor->is_active)
                        <span class="badge badge-active">Active</span>
                    @else
                        <span class="badge badge-inactive">Inactive</span>
                    @endif
                </div>
            </div>
        </div>

        @if(!$vendor->is_active && $vendor->deactivation_note)
            <div class="deactivation-note">
                <h4>Deactivation Reason</h4>
                <p>{{ $vendor->deactivation_note }}</p>
            </div>
        @endif
    </div>
</div>

{{-- Uploaded Documents --}}
<div class="vr-card">
    <div class="vr-card-header">Uploaded Documents</div>
    <div class="vr-card-body">
        <div class="doc-item">
            <span class="doc-name">🪪 Citizenship Certificate</span>
            @if($vendor->citizenship_certificate)
                <a href="{{ Storage::url($vendor->citizenship_certificate) }}" target="_blank" class="doc-link">View Document</a>
            @else
                <span class="doc-missing">Not uploaded</span>
            @endif
        </div>
        <div class="doc-item">
            <span class="doc-name">📄 Company Registration Certificate</span>
            @if($vendor->company_registration_certificate)
                <a href="{{ Storage::url($vendor->company_registration_certificate) }}" target="_blank" class="doc-link">View Document</a>
            @else
                <span class="doc-missing">Not uploaded</span>
            @endif
        </div>
        @if($vendor->tax_certificate)
        <div class="doc-item">
            <span class="doc-name">🧾 Tax Certificate</span>
            <a href="{{ Storage::url($vendor->tax_certificate) }}" target="_blank" class="doc-link">View Document</a>
        </div>
        @endif
    </div>
</div>

{{-- Actions --}}
<div class="vr-card">
    <div class="vr-card-header">Actions</div>
    <div class="vr-card-body">
        <div class="action-row">
            @if(!$vendor->is_verified)
                <form method="POST" action="{{ route('admin.vendors.approve', $vendor) }}">
                    @csrf
                    <button type="submit" class="btn btn-approve"
                        onclick="return confirm('Approve this vendor?')">✓ Approve Vendor</button>
                </form>
                <form method="POST" action="{{ route('admin.vendors.reject', $vendor) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-reject"
                        onclick="return confirm('Reject and delete this application?')">✕ Reject & Delete</button>
                </form>
            @elseif($vendor->is_active)
                <button class="btn btn-deactivate" onclick="showDeactivateModal()">⏸ Deactivate Vendor</button>
            @else
                <form method="POST" action="{{ route('admin.vendors.reactivate', $vendor) }}">
                    @csrf
                    <button type="submit" class="btn btn-reactivate">▶ Reactivate Vendor</button>
                </form>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function showDeactivateModal() {
    const reason = prompt('Please provide a reason for deactivation:');
    if (reason && reason.trim()) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.vendors.deactivate", $vendor) }}';
        const csrf = document.createElement('input');
        csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
        const note = document.createElement('input');
        note.type = 'hidden'; note.name = 'deactivation_note'; note.value = reason.trim();
        form.appendChild(csrf); form.appendChild(note);
        document.body.appendChild(form); form.submit();
    }
}
</script>
@endpush

@endsection
