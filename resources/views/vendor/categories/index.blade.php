@extends('layouts.dashboard')

@section('title', 'Categories - Vendor')
@section('panel-name', 'Vendor Panel')
@section('page-title', 'Available Categories')
@section('navbar-color', '#10b981')

@section('sidebar-nav')
@include('vendor.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <h2>Available Categories</h2>
</div>

<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="table-image">
                        @else
                            <div class="no-image">No Image</div>
                        @endif
                    </td>
                    <td><strong>{{ $category->name }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">No categories available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    {{ $categories->links() }}
</div>

<style>
.page-header {
    margin-bottom: 2rem;
}

.page-header h2 {
    color: #1f2937;
    font-size: 24px;
}

.table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    background: #f9fafb;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.data-table td {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    color: #6b7280;
}

.table-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.no-image {
    width: 60px;
    height: 60px;
    background: #f3f4f6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    color: #9ca3af;
}

.text-center {
    text-align: center;
}

.pagination-wrapper {
    margin-top: 1rem;
}
</style>
@endsection
