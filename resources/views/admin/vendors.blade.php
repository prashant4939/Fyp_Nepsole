@extends('layouts.dashboard')

@section('title', 'Manage Vendors - NepSole')
@section('panel-name', 'Admin Panel')
@section('navbar-color', '#6366f1')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #111827;
    }

    .btn-back {
        padding: 0.5rem 1rem;
        background: #e5e7eb;
        color: #374151;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
    }

    .btn-back:hover {
        background: #d1d5db;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        text-align: left;
        padding: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .table td {
        padding: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
        color: #111827;
        font-size: 0.875rem;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-active { background: #d1fae5; color: #065f46; }
    .badge-inactive { background: #fee2e2; color: #991b1b; }

    .btn-action {
        padding: 0.375rem 0.75rem;
        border: none;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-right: 0.5rem;
    }

    .btn-toggle {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }

    .pagination a, .pagination span {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        text-decoration: none;
        color: #374151;
    }

    .pagination .active {
        background: #6366f1;
        color: white;
        border-color: #6366f1;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Manage Vendors</h1>
    <a href="{{ route('admin.dashboard') }}" class="btn-back">← Back to Dashboard</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<div class="card">
    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Total Orders</th>
                    <th>Total Sales</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                <tr>
                    <td>{{ $vendor->id }}</td>
                    <td>{{ $vendor->name }}</td>
                    <td>{{ $vendor->email }}</td>
                    <td>{{ $vendor->orders_as_vendor_count }}</td>
                    <td>Rs. {{ number_format($vendor->orders_as_vendor_sum_total_amount ?? 0, 2) }}</td>
                    <td>
                        <span class="badge {{ $vendor->email_verified_at ? 'badge-active' : 'badge-inactive' }}">
                            {{ $vendor->email_verified_at ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $vendor->created_at->format('M d, Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.toggle', $vendor->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-action btn-toggle">
                                {{ $vendor->email_verified_at ? 'Disable' : 'Enable' }}
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('admin.users.delete', $vendor->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this vendor?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #9ca3af; padding: 2rem;">No vendors found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $vendors->links() }}
    </div>
</div>
@endsection
