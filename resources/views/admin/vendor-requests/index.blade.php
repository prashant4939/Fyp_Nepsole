@extends('layouts.dashboard')

@section('title', 'Vendor Requests - NepSole')
@section('panel-name', 'Admin Panel')
@section('navbar-color', '#6366f1')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .page-title { font-size: 1.5rem; font-weight: 700; color: #111827; }
    .page-subtitle { font-size: 13px; color: #6b7280; margin-top: 2px; }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px solid #f3f4f6;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .stat-label { font-size: 12px; color: #6b7280; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }
    .stat-value { font-size: 1.75rem; font-weight: 700; color: #111827; margin-top: 4px; }

    .card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #f3f4f6;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        font-weight: 600;
        font-size: 15px;
        color: #111827;
    }
    table { width: 100%; border-collapse: collapse; }
    th {
        padding: 0.75rem 1rem;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: #f9fafb;
        border-bottom: 1px solid #f3f4f6;
    }
    td {
        padding: 0.875rem 1rem;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #f9fafb;
        vertical-align: middle;
    }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fafafa; }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-pending  { background: #fef3c7; color: #92400e; }
    .badge-approved { background: #d1fae5; color: #065f46; }
    .badge-rejected { background: #fee2e2; color: #991b1b; }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-approve { background: #d1fae5; color: #065f46; }
    .btn-approve:hover { background: #a7f3d0; }
    .btn-reject  { background: #fee2e2; color: #991b1b; }
    .btn-reject:hover  { background: #fecaca; }

    .alert {
        padding: 0.875rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.25rem;
        font-size: 14px;
        font-weight: 500;
    }
    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-error   { background: #fee2e2; color: #991b1b; }

    .empty-state { text-align: center; padding: 3rem 2rem; color: #9ca3af; }
    .empty-state h3 { font-size: 1rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; }

    .pagination-wrap {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .pagination-info { font-size: 13px; color: #6b7280; }

    /* Reject modal */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .modal {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        width: 100%;
        max-width: 460px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }
    .modal h3 { font-size: 1.1rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem; }
    .modal p  { font-size: 13px; color: #6b7280; margin-bottom: 1rem; }
    .modal textarea {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        resize: vertical;
        min-height: 100px;
        box-sizing: border-box;
        margin-bottom: 1rem;
    }
    .modal textarea:focus { outline: none; border-color: #6366f1; }
    .modal-actions { display: flex; gap: 0.75rem; justify-content: flex-end; }
    .btn-cancel { background: #f3f4f6; color: #374151; }
    .btn-cancel:hover { background: #e5e7eb; }
    .btn-confirm-reject { background: #dc2626; color: #fff; padding: 8px 16px; }
    .btn-confirm-reject:hover { background: #b91c1c; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Vendor Requests</div>
        <div class="page-subtitle">Review and manage vendor applications</div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
@endif

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-label">Total</div>
        <div class="stat-value">{{ $requests->total() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pending</div>
        <div class="stat-value">{{ $requests->getCollection()->where('status','pending')->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Approved</div>
        <div class="stat-value">{{ $requests->getCollection()->where('status','approved')->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Rejected</div>
        <div class="stat-value">{{ $requests->getCollection()->where('status','rejected')->count() }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">All Applications</div>

    @if($requests->isEmpty())
        <div class="empty-state">
            <h3>No vendor requests yet</h3>
            <p>Applications submitted via the "Become a Vendor" form will appear here.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Shop Name</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->name }}</td>
                    <td>{{ $req->email }}</td>
                    <td>{{ $req->phone }}</td>
                    <td>{{ $req->shop_name }}</td>
                    <td style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $req->address }}">{{ $req->address }}</td>
                    <td>
                        <span class="badge badge-{{ $req->status }}">{{ ucfirst($req->status) }}</span>
                        @if($req->status === 'rejected' && $req->admin_message)
                            <div style="font-size:11px;color:#6b7280;margin-top:3px;max-width:140px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $req->admin_message }}">
                                {{ $req->admin_message }}
                            </div>
                        @endif
                    </td>
                    <td style="white-space:nowrap;">{{ $req->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($req->status === 'pending')
                            <form method="POST" action="{{ route('admin.vendor-requests.approve', $req) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-approve"
                                    onclick="return confirm('Approve this vendor request and create their account?')">
                                    ✓ Approve
                                </button>
                            </form>
                            <button type="button" class="btn btn-reject"
                                onclick="openRejectModal({{ $req->id }}, '{{ addslashes($req->name) }}')">
                                ✕ Reject
                            </button>
                        @else
                            <span style="font-size:12px;color:#9ca3af;">Processed</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-wrap">
            <div class="pagination-info">
                Showing {{ $requests->firstItem() }}–{{ $requests->lastItem() }} of {{ $requests->total() }} requests
            </div>
            {{ $requests->links() }}
        </div>
    @endif
</div>

{{-- Reject Modal --}}
<div class="modal-overlay" id="rejectModal">
    <div class="modal">
        <h3>Reject Vendor Request</h3>
        <p>You are rejecting the application from <strong id="rejectVendorName"></strong>. Please provide a reason — it will be emailed to the applicant.</p>
        <form method="POST" id="rejectForm">
            @csrf
            <textarea name="admin_message" placeholder="Enter rejection reason..." required></textarea>
            <div class="modal-actions">
                <button type="button" class="btn btn-cancel" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="btn btn-confirm-reject">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(id, name) {
        document.getElementById('rejectVendorName').textContent = name;
        document.getElementById('rejectForm').action = '/admin/vendor-requests/' + id + '/reject';
        document.getElementById('rejectModal').classList.add('active');
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('active');
    }
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) closeRejectModal();
    });
</script>
@endpush
@endsection
