@extends('layouts.dashboard')

@section('title', 'Vendor Management - Admin')
@section('panel-name', 'Admin Panel')
@section('page-title', 'Vendor Management')
@section('navbar-color', '#6366f1')

@section('sidebar-nav')
@include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
.alert { padding: 1rem 1.25rem; border-radius: 8px; margin-bottom: 1.25rem; font-size: 14px; font-weight: 500; }
.alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

.tabs { display: flex; gap: 0; margin-bottom: 1.5rem; border-bottom: 2px solid #e5e7eb; flex-wrap: wrap; }
.tab {
    padding: 0.875rem 1.5rem; background: none; border: none; font-size: 14px;
    font-weight: 500; cursor: pointer; color: #6b7280;
    border-bottom: 2px solid transparent; margin-bottom: -2px;
    transition: all 0.2s; white-space: nowrap;
}
.tab:hover { color: #6366f1; }
.tab.active { color: #6366f1; border-bottom-color: #6366f1; font-weight: 600; }
.tab-content { display: none; }
.tab-content.active { display: block; }

.table-container { background: white; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); overflow: hidden; }
.table { width: 100%; border-collapse: collapse; }
.table th {
    background: #f9fafb; padding: 0.875rem 1rem; text-align: left;
    font-size: 12px; font-weight: 600; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e5e7eb;
}
.table td { padding: 0.875rem 1rem; border-bottom: 1px solid #f3f4f6; color: #374151; font-size: 14px; vertical-align: middle; }
.table tr:last-child td { border-bottom: none; }
.table tr:hover td { background: #fafafa; }

.badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; }
.badge-pending  { background: #fef3c7; color: #92400e; }
.badge-approved { background: #d1fae5; color: #065f46; }
.badge-rejected { background: #fee2e2; color: #991b1b; }
.badge-inactive { background: #f3f4f6; color: #6b7280; }

.action-buttons { display: flex; gap: 0.4rem; flex-wrap: wrap; }
.btn { padding: 5px 12px; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; }
.btn-view       { background: #e0e7ff; color: #3730a3; }
.btn-view:hover { background: #c7d2fe; }
.btn-approve       { background: #d1fae5; color: #065f46; }
.btn-approve:hover { background: #a7f3d0; }
.btn-reject       { background: #fee2e2; color: #991b1b; }
.btn-reject:hover { background: #fecaca; }
.btn-deactivate       { background: #fed7aa; color: #9a3412; }
.btn-deactivate:hover { background: #fdba74; }
.btn-reactivate       { background: #bfdbfe; color: #1e40af; }
.btn-reactivate:hover { background: #93c5fd; }

.empty-state { text-align: center; padding: 3rem 2rem; color: #9ca3af; }
.empty-state h3 { font-size: 1rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; }

.modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
.modal-overlay.open { display: flex; }
.modal { background: #fff; border-radius: 16px; padding: 2rem; width: 100%; max-width: 460px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
.modal h3 { font-size: 1.1rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem; }
.modal p  { font-size: 13px; color: #6b7280; margin-bottom: 1rem; }
.modal textarea { width: 100%; padding: 0.65rem 0.9rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; resize: vertical; min-height: 100px; box-sizing: border-box; margin-bottom: 1rem; font-family: inherit; }
.modal textarea:focus { outline: none; border-color: #6366f1; }
.modal-actions { display: flex; gap: 0.75rem; justify-content: flex-end; }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
@endif

<div class="tabs">
    <button class="tab active" onclick="showTab('req-all', this)">
        All Requests ({{ $vendorRequests->count() }})
    </button>
    <button class="tab" onclick="showTab('req-pending', this)">
        Pending
        @if($vendorRequests->where('status','pending')->count())
            <span style="background:#fef3c7;color:#92400e;border-radius:10px;padding:1px 7px;font-size:11px;margin-left:4px;">{{ $vendorRequests->where('status','pending')->count() }}</span>
        @endif
    </button>
    <button class="tab" onclick="showTab('req-approved', this)">
        Approved ({{ $vendorRequests->where('status','approved')->count() }})
    </button>
    <button class="tab" onclick="showTab('req-rejected', this)">
        Rejected ({{ $vendorRequests->where('status','rejected')->count() }})
    </button>
    <button class="tab" onclick="showTab('active-vendors', this)">
        Active Vendors ({{ $approvedVendors->count() }})
    </button>
</div>

{{-- All Requests --}}
<div id="req-all" class="tab-content active">
    @include('admin.vendors.partials.requests-table', ['rows' => $vendorRequests])
</div>

{{-- Pending --}}
<div id="req-pending" class="tab-content">
    @include('admin.vendors.partials.requests-table', ['rows' => $vendorRequests->where('status','pending')])
</div>

{{-- Approved --}}
<div id="req-approved" class="tab-content">
    @include('admin.vendors.partials.requests-table', ['rows' => $vendorRequests->where('status','approved')])
</div>

{{-- Rejected --}}
<div id="req-rejected" class="tab-content">
    @include('admin.vendors.partials.requests-table', ['rows' => $vendorRequests->where('status','rejected')])
</div>

{{-- Active Vendors --}}
<div id="active-vendors" class="tab-content">
    <div class="table-container">
        @if($approvedVendors->count())
            <table class="table">
                <thead><tr>
                    <th>Vendor Name</th><th>Business Name</th><th>Email</th>
                    <th>Business Type</th><th>Approved Date</th><th>Status</th><th>Actions</th>
                </tr></thead>
                <tbody>
                @foreach($approvedVendors as $vendor)
                <tr>
                    <td>{{ $vendor->user->name }}</td>
                    <td>{{ $vendor->business_name }}</td>
                    <td>{{ $vendor->user->email }}</td>
                    <td>{{ $vendor->getBusinessTypeLabel() }}</td>
                    <td>{{ $vendor->updated_at->format('M d, Y') }}</td>
                    <td>
                        @if($vendor->is_active)
                            <span class="badge badge-approved">Active</span>
                        @else
                            <span class="badge badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.vendors.show', $vendor) }}" class="btn btn-view">View</a>
                            @if($vendor->is_active)
                                <button class="btn btn-deactivate" onclick="showDeactivateModal({{ $vendor->id }})">Deactivate</button>
                            @else
                                <form method="POST" action="{{ route('admin.vendors.reactivate', $vendor) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-reactivate">Reactivate</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state"><h3>No Active Vendors</h3><p>No vendors have been approved yet.</p></div>
        @endif
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal-overlay" id="rejectModal">
    <div class="modal">
        <h3>Reject Vendor Request</h3>
        <p>Rejecting application from <strong id="rejectName"></strong>. The reason will be emailed to the applicant.</p>
        <form method="POST" id="rejectForm">
            @csrf
            <textarea name="admin_message" placeholder="Enter rejection reason..." required></textarea>
            <div class="modal-actions">
                <button type="button" onclick="closeRejectModal()"
                    style="padding:8px 16px;background:#f3f4f6;color:#374151;border:none;border-radius:6px;font-weight:600;cursor:pointer;">Cancel</button>
                <button type="submit"
                    style="padding:8px 16px;background:#dc2626;color:#fff;border:none;border-radius:6px;font-weight:600;cursor:pointer;">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function showTab(id, el) {
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    el.classList.add('active');
}
function openRejectModal(id, name) {
    document.getElementById('rejectName').textContent = name;
    document.getElementById('rejectForm').action = '/admin/vendor-requests/' + id + '/reject';
    document.getElementById('rejectModal').classList.add('open');
}
function closeRejectModal() {
    document.getElementById('rejectModal').classList.remove('open');
}
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
function showDeactivateModal(vendorId) {
    const reason = prompt('Please provide a reason for deactivation:');
    if (reason && reason.trim()) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/vendors/${vendorId}/deactivate`;
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
