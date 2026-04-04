@extends('layouts.dashboard')

@section('title', 'Customer Management - NepSole')
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

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
    }

    .page-subtitle {
        font-size: 13px;
        color: #6b7280;
        margin-top: 2px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f3f4f6;
        color: #374151;
        text-decoration: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-back:hover { background: #e5e7eb; }

    /* Stats row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-mini {
        background: white;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 0.875rem;
    }

    .stat-mini-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-mini-label { font-size: 12px; color: #6b7280; }
    .stat-mini-value { font-size: 1.375rem; font-weight: 700; color: #111827; }

    /* Card */
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #111827;
    }

    /* Search */
    .search-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f9fafb;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.5rem 0.875rem;
        min-width: 240px;
    }

    .search-box input {
        border: none;
        background: none;
        outline: none;
        font-size: 14px;
        color: #374151;
        width: 100%;
    }

    /* Table */
    .table-wrap { overflow-x: auto; }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        padding: 0.875rem 1.25rem;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    tbody td {
        padding: 1rem 1.25rem;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #fafafa; }

    /* Avatar */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .user-avatar-placeholder {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .user-name { font-weight: 600; color: #111827; font-size: 14px; }
    .user-email { font-size: 12px; color: #9ca3af; margin-top: 1px; }

    /* Badge */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-active   { background: #d1fae5; color: #065f46; }
    .badge-inactive { background: #fee2e2; color: #991b1b; }

    /* Actions */
    .action-btn {
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

    .btn-disable  { background: #fef3c7; color: #92400e; }
    .btn-enable   { background: #d1fae5; color: #065f46; }
    .btn-delete   { background: #fee2e2; color: #991b1b; }

    .btn-disable:hover  { background: #fde68a; }
    .btn-enable:hover   { background: #a7f3d0; }
    .btn-delete:hover   { background: #fecaca; }

    /* Alert */
    .alert {
        padding: 0.875rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.25rem;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-error   { background: #fee2e2; color: #991b1b; }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #9ca3af;
    }

    .empty-state svg { margin-bottom: 1rem; opacity: 0.4; }
    .empty-state h3 { font-size: 1rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; }
    .empty-state p  { font-size: 14px; }

    /* Pagination */
    .pagination-wrap {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination-info { font-size: 13px; color: #6b7280; }

    .pagination-wrap nav { display: flex; gap: 0.25rem; }

    .pagination-wrap .pagination {
        display: flex;
        gap: 0.25rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination-wrap .page-item .page-link {
        padding: 0.4rem 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 13px;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
    }

    .pagination-wrap .page-item.active .page-link {
        background: #6366f1;
        border-color: #6366f1;
        color: white;
    }

    .pagination-wrap .page-item .page-link:hover {
        background: #f3f4f6;
    }
</style>
@endpush

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Customer Management</h1>
        <p class="page-subtitle">View and manage all registered customers</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn-back">
        ← Back to Dashboard
    </a>
</div>

<!-- Alerts -->
@if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">✗ {{ session('error') }}</div>
@endif

<!-- Stats -->
<div class="stats-row">
    <div class="stat-mini">
        <div class="stat-mini-icon" style="background:#eef2ff;">👥</div>
        <div>
            <div class="stat-mini-label">Total Customers</div>
            <div class="stat-mini-value">{{ $customers->total() }}</div>
        </div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-icon" style="background:#d1fae5;">✓</div>
        <div>
            <div class="stat-mini-label">Active</div>
            <div class="stat-mini-value">{{ $customers->getCollection()->where('email_verified_at', '!=', null)->count() }}</div>
        </div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-icon" style="background:#fee2e2;">✗</div>
        <div>
            <div class="stat-mini-label">Inactive</div>
            <div class="stat-mini-value">{{ $customers->getCollection()->whereNull('email_verified_at')->count() }}</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card">
    <div class="card-header">
        <span class="card-title">All Customers</span>
        <div class="search-box">
            <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Search customers..." oninput="filterTable(this.value)">
        </div>
    </div>

    <div class="table-wrap">
        <table id="customersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Orders</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td style="color:#9ca3af;">{{ $customer->id }}</td>

                    <td>
                        <div class="user-cell">
                            @if($customer->profile_image)
                                <img src="{{ asset('storage/' . $customer->profile_image) }}" class="user-avatar" alt="">
                            @else
                                <div class="user-avatar-placeholder">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="user-name">{{ $customer->name }}</div>
                                <div class="user-email">{{ $customer->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span style="font-weight:600;">{{ $customer->orders_as_customer_count }}</span>
                        <span style="color:#9ca3af;font-size:12px;"> orders</span>
                    </td>

                    <td>
                        @if($customer->email_verified_at)
                            <span class="badge badge-active">● Active</span>
                        @else
                            <span class="badge badge-inactive">● Inactive</span>
                        @endif
                    </td>

                    <td style="color:#6b7280;">{{ $customer->created_at->format('M d, Y') }}</td>

                    <td>
                        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                            <!-- Toggle Status -->
                            <form method="POST" action="{{ route('admin.customers.toggle', $customer->id) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn {{ $customer->email_verified_at ? 'btn-disable' : 'btn-enable' }}">
                                    {{ $customer->email_verified_at ? 'Disable' : 'Enable' }}
                                </button>
                            </form>

                            <!-- Delete -->
                            <form method="POST" action="{{ route('admin.customers.destroy', $customer->id) }}"
                                  style="display:inline;"
                                  onsubmit="return confirm('Delete {{ addslashes($customer->name) }}? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <h3>No customers found</h3>
                            <p>Customers will appear here once they register.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($customers->hasPages())
    <div class="pagination-wrap">
        <span class="pagination-info">
            Showing {{ $customers->firstItem() }}–{{ $customers->lastItem() }} of {{ $customers->total() }} customers
        </span>
        {{ $customers->links() }}
    </div>
    @endif
</div>

<script>
function filterTable(query) {
    const rows = document.querySelectorAll('#customersTable tbody tr');
    const q = query.toLowerCase();
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>
@endsection
