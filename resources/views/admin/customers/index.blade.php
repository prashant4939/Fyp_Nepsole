@extends('layouts.dashboard')

@section('title', 'Customer Management - Admin')
@section('panel-name', 'Admin Panel')
@section('page-title', 'Customer Management')
@section('navbar-color', '#6366f1')

@section('sidebar-nav')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="customers-container">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Total Orders</th>
                    <th>Joined Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->orders_count }}</td>
                    <td>{{ $customer->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No customers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $customers->links() }}
    </div>
</div>

<style>
    .customers-container {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-bordered {
        border: 1px solid #e5e7eb;
    }
    
    .table-hover tbody tr:hover {
        background: #f9fafb;
    }
    
    .table-light {
        background: #f3f4f6;
    }
    
    .table th, .table td {
        padding: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }
    
    .text-center {
        text-align: center;
    }
    
    .mt-3 {
        margin-top: 1rem;
    }
</style>
@endsection
