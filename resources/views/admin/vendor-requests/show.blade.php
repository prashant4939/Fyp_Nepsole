@extends('layouts.dashboard')

@section('title', 'Vendor Request - ' . $vendorRequest->name)
@section('panel-name', 'Admin Panel')
@section('page-title', 'Vendor Request Details')
@section('navbar-color', '#6366f1')

@section('sidebar-nav')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
    .vr-card { background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;margin-bottom:1.5rem; }
    .vr-card-header { background:#f9fafb;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;font-size:16px;font-weight:600;color:#111827; }
    .vr-card-body { padding:1.5rem; }
    .info-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem; }
    .info-item .label { font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px; }
    .info-item .value { font-size:15px;color:#111827;font-weight:500; }
    .badge { display:inline-flex;align-items:center;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600; }
    .badge-pending  { background:#fef3c7;color:#92400e; }
    .badge-approved { background:#d1fae5;color:#065f46; }
    .badge-rejected { background:#fee2e2;color:#991b1b; }
    .doc-item { display:flex;justify-content:space-between;align-items:center;padding:0.875rem 1rem;background:#f9fafb;border-radius:8px;margin-bottom:0.5rem; }
    .doc-name { font-size:14px;font-weight:500;color:#374151; }
    .doc-link { color:#6366f1;text-decoration:none;font-weight:600;font-size:13px;padding:6px 14px;background:#e0e7ff;border-radius:6px;transition:background 0.2s; }
    .doc-link:hover { background:#c7d2fe; }
    .doc-missing { font-size:13px;color:#9ca3af;font-style:italic; }
    .btn { padding:0.65rem 1.5rem;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;transition:all 0.2s;display:inline-block; }
    .btn-approve { background:#10b981;color:#fff; }
    .btn-approve:hover { background:#059669; }
    .btn-reject  { background:#ef4444;color:#fff; }
    .btn-reject:hover  { background:#dc2626; }
    .reject-box { display:none;margin-top:1rem;background:#fff7f7;border:1px solid #fecaca;border-radius:10px;padding:1.25rem; }
    .reject-box textarea { width:100%;padding:0.65rem 0.9rem;border:1px solid #d1d5db;border-radius:8px;font-size:14px;resize:vertical;min-height:100px;box-sizing:border-box;font-family:inherit; }
    .reject-box textarea:focus { outline:none;border-color:#6366f1; }
    .alert-success { background:#d1fae5;color:#065f46;padding:0.875rem 1.25rem;border-radius:10px;margin-bottom:1.25rem;font-size:14px;font-weight:500; }
    .alert-error   { background:#fee2e2;color:#991b1b;padding:0.875rem 1.25rem;border-radius:10px;margin-bottom:1.25rem;font-size:14px; }
    .back-link { display:inline-block;color:#6366f1;text-decoration:none;font-weight:500;font-size:14px;margin-bottom:1.25rem; }
    .back-link:hover { text-decoration:underline; }
</style>
@endpush

@section('content')

<a href="{{ route('admin.vendors.index') }}" class="back-link">← Back to Vendor Management</a>

@if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-error">❌ {{ session('error') }}</div>
@endif

{{-- Applicant Info --}}
<div class="vr-card">
    <div class="vr-card-header">Applicant Information</div>
    <div class="vr-card-body">
        <div class="info-grid">
            <div class="info-item">
                <div class="label">Full Name</div>
                <div class="value">{{ $vendorRequest->name }}</div>
            </div>
            <div class="info-item">
                <div class="label">Email</div>
                <div class="value">{{ $vendorRequest->email }}</div>
            </div>
            <div class="info-item">
                <div class="label">Phone</div>
                <div class="value">{{ $vendorRequest->phone }}</div>
            </div>
            <div class="info-item">
                <div class="label">Shop / Business Name</div>
                <div class="value">{{ $vendorRequest->shop_name }}</div>
            </div>
            <div class="info-item">
                <div class="label">Address</div>
                <div class="value">{{ $vendorRequest->address }}</div>
            </div>
            <div class="info-item">
                <div class="label">Submitted</div>
                <div class="value">{{ $vendorRequest->created_at->format('M d, Y h:i A') }}</div>
            </div>
            <div class="info-item">
                <div class="label">Status</div>
                <div class="value">
                    <span class="badge badge-{{ $vendorRequest->status }}">{{ ucfirst($vendorRequest->status) }}</span>
                </div>
            </div>
            @if($vendorRequest->status === 'rejected' && $vendorRequest->admin_message)
            <div class="info-item" style="grid-column:1/-1;">
                <div class="label">Rejection Reason</div>
                <div class="value" style="color:#991b1b;">{{ $vendorRequest->admin_message }}</div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Documents --}}
<div class="vr-card">
    <div class="vr-card-header">Submitted Documents</div>
    <div class="vr-card-body">
        <div class="doc-item">
            <span class="doc-name">🪪 Citizenship Photo</span>
            @if($vendorRequest->citizenship_photo)
                <a href="{{ Storage::url($vendorRequest->citizenship_photo) }}" target="_blank" class="doc-link">View Document</a>
            @else
                <span class="doc-missing">Not uploaded</span>
            @endif
        </div>
        <div class="doc-item">
            <span class="doc-name">📄 Business Registration Document</span>
            @if($vendorRequest->business_document)
                <a href="{{ Storage::url($vendorRequest->business_document) }}" target="_blank" class="doc-link">View Document</a>
            @else
                <span class="doc-missing">Not uploaded</span>
            @endif
        </div>
        <div class="doc-item">
            <span class="doc-name">🧾 Tax Clearance Certificate</span>
            @if($vendorRequest->tax_clearance)
                <a href="{{ Storage::url($vendorRequest->tax_clearance) }}" target="_blank" class="doc-link">View Document</a>
            @else
                <span class="doc-missing">Not provided (optional)</span>
            @endif
        </div>
    </div>
</div>

{{-- Actions --}}
@if($vendorRequest->status === 'pending')
<div class="vr-card">
    <div class="vr-card-header">Actions</div>
    <div class="vr-card-body">
        <div style="display:flex;gap:1rem;flex-wrap:wrap;">
            <form method="POST" action="{{ route('admin.vendor-requests.approve', $vendorRequest) }}">
                @csrf
                <button type="submit" class="btn btn-approve"
                    onclick="return confirm('Approve this vendor? A 4-digit PIN will be generated and emailed to them.')">
                    ✓ Approve Vendor
                </button>
            </form>
            <button type="button" class="btn btn-reject"
                onclick="document.getElementById('rejectBox').style.display='block';this.style.display='none';">
                ✕ Reject Application
            </button>
        </div>

        <div id="rejectBox" class="reject-box">
            <p style="font-size:13px;color:#991b1b;margin-bottom:0.75rem;font-weight:600;">
                Provide a reason — it will be emailed to the applicant.
            </p>
            <form method="POST" action="{{ route('admin.vendor-requests.reject', $vendorRequest) }}">
                @csrf
                <textarea name="admin_message" placeholder="Enter rejection reason..." required></textarea>
                <div style="display:flex;gap:0.75rem;margin-top:0.75rem;">
                    <button type="button"
                        onclick="document.getElementById('rejectBox').style.display='none';document.querySelector('.btn-reject').style.display='inline-block';"
                        style="padding:8px 16px;background:#f3f4f6;color:#374151;border:none;border-radius:6px;font-weight:600;cursor:pointer;">
                        Cancel
                    </button>
                    <button type="submit"
                        style="padding:8px 16px;background:#dc2626;color:#fff;border:none;border-radius:6px;font-weight:600;cursor:pointer;">
                        Confirm Rejection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
