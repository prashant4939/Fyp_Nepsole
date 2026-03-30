@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - NepSole')
@section('panel-name', 'Admin Panel')
@section('page-title', 'Dashboard')
@section('navbar-color', '#6366f1')

@section('sidebar-nav')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="welcome-card">
    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p>You are logged in as an Administrator.</p>
    <span class="role-badge">Admin</span>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-content">
            <h3>Total Users</h3>
            <p class="stat-number">{{ $totalUsers }}</p>
            <span class="stat-label">Registered Customers</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">🏪</div>
        <div class="stat-content">
            <h3>Total Vendors</h3>
            <p class="stat-number">{{ $totalVendors }}</p>
            <span class="stat-label">Active Vendors</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-content">
            <h3>Orders Dispatched</h3>
            <p class="stat-number">{{ $ordersDispatched }}</p>
            <span class="stat-label">Total Dispatched</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">🛍️</div>
        <div class="stat-content">
            <h3>Total Products</h3>
            <p class="stat-number">{{ $totalProducts }}</p>
            <span class="stat-label">All Products</span>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="revenue-section">
    <div class="chart-header">
        <h2 class="section-title">Vendor Revenue Analytics</h2>
        <div class="filter-buttons">
            <button class="filter-btn active" data-period="weekly">Weekly</button>
            <button class="filter-btn" data-period="monthly">Monthly</button>
            <button class="filter-btn" data-period="yearly">Yearly</button>
        </div>
    </div>
    
    <div class="chart-container">
        <div id="weekly-chart" class="chart-content active">
            <h3 class="chart-subtitle">Last 7 Days</h3>
            @if($vendorRevenueData['weekly']->count() > 0)
                <div class="chart-wrapper">
                    <div class="y-axis-label">Revenue (Rs.)</div>
                    <div class="chart-area">
                        <div class="chart-bars">
                            @php
                                $maxWeekly = $vendorRevenueData['weekly']->max('revenue');
                            @endphp
                            @foreach($vendorRevenueData['weekly'] as $data)
                                <div class="chart-item">
                                    <div class="bar-container">
                                        <div class="bar bar-weekly" style="height: {{ $maxWeekly > 0 ? ($data['revenue'] / $maxWeekly * 100) : 0 }}%">
                                            <span class="bar-value">Rs. {{ number_format($data['revenue'], 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="bar-label">{{ $data['vendor_name'] }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="x-axis-label">Vendors</div>
                    </div>
                </div>
            @else
                <p class="no-data">No revenue data available for this period</p>
            @endif
        </div>
        
        <div id="monthly-chart" class="chart-content">
            <h3 class="chart-subtitle">Last 30 Days</h3>
            @if($vendorRevenueData['monthly']->count() > 0)
                <div class="chart-wrapper">
                    <div class="y-axis-label">Revenue (Rs.)</div>
                    <div class="chart-area">
                        <div class="chart-bars">
                            @php
                                $maxMonthly = $vendorRevenueData['monthly']->max('revenue');
                            @endphp
                            @foreach($vendorRevenueData['monthly'] as $data)
                                <div class="chart-item">
                                    <div class="bar-container">
                                        <div class="bar bar-monthly" style="height: {{ $maxMonthly > 0 ? ($data['revenue'] / $maxMonthly * 100) : 0 }}%">
                                            <span class="bar-value">Rs. {{ number_format($data['revenue'], 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="bar-label">{{ $data['vendor_name'] }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="x-axis-label">Vendors</div>
                    </div>
                </div>
            @else
                <p class="no-data">No revenue data available for this period</p>
            @endif
        </div>
        
        <div id="yearly-chart" class="chart-content">
            <h3 class="chart-subtitle">Last 365 Days</h3>
            @if($vendorRevenueData['yearly']->count() > 0)
                <div class="chart-wrapper">
                    <div class="y-axis-label">Revenue (Rs.)</div>
                    <div class="chart-area">
                        <div class="chart-bars">
                            @php
                                $maxYearly = $vendorRevenueData['yearly']->max('revenue');
                            @endphp
                            @foreach($vendorRevenueData['yearly'] as $data)
                                <div class="chart-item">
                                    <div class="bar-container">
                                        <div class="bar bar-yearly" style="height: {{ $maxYearly > 0 ? ($data['revenue'] / $maxYearly * 100) : 0 }}%">
                                            <span class="bar-value">Rs. {{ number_format($data['revenue'], 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="bar-label">{{ $data['vendor_name'] }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="x-axis-label">Vendors</div>
                    </div>
                </div>
            @else
                <p class="no-data">No revenue data available for this period</p>
            @endif
        </div>
    </div>
</div>

<style>
/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    font-size: 2.5rem;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-content h3 {
    color: #6b7280;
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.stat-number {
    color: #1f2937;
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    line-height: 1;
}

.stat-label {
    color: #9ca3af;
    font-size: 0.8rem;
}

/* Revenue Section */
.revenue-section {
    margin-top: 3rem;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.section-title {
    color: #1f2937;
    font-size: 1.5rem;
    margin: 0;
    font-weight: 600;
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
    background: #f3f4f6;
    padding: 0.25rem;
    border-radius: 8px;
}

.filter-btn {
    padding: 0.5rem 1.25rem;
    border: none;
    background: transparent;
    color: #6b7280;
    font-weight: 500;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
}

.filter-btn:hover {
    background: #e5e7eb;
}

.filter-btn.active {
    background: #6366f1;
    color: white;
}

.chart-container {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: relative;
}

.chart-content {
    display: none;
}

.chart-content.active {
    display: block;
}

.chart-subtitle {
    color: #6b7280;
    font-size: 1rem;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.chart-wrapper {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.y-axis-label {
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    color: #4b5563;
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
}

.chart-area {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.chart-bars {
    display: flex;
    gap: 1.5rem;
    align-items: flex-end;
    min-height: 300px;
    padding: 1rem 0;
    border-left: 2px solid #e5e7eb;
    border-bottom: 2px solid #e5e7eb;
    padding-left: 1rem;
    padding-bottom: 1rem;
}

.chart-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.bar-container {
    width: 100%;
    height: 250px;
    display: flex;
    align-items: flex-end;
    justify-content: center;
}

.bar {
    width: 80%;
    border-radius: 8px 8px 0 0;
    position: relative;
    transition: all 0.3s ease;
    min-height: 30px;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding-top: 0.5rem;
}

.bar:hover {
    opacity: 0.8;
}

.bar-weekly {
    background: linear-gradient(to top, #6366f1, #818cf8);
}

.bar-monthly {
    background: linear-gradient(to top, #10b981, #34d399);
}

.bar-yearly {
    background: linear-gradient(to top, #f59e0b, #fbbf24);
}

.bar-value {
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
    word-break: break-word;
}

.bar-label {
    margin-top: 0.75rem;
    color: #4b5563;
    font-size: 0.85rem;
    text-align: center;
    font-weight: 500;
    word-break: break-word;
}

.x-axis-label {
    color: #4b5563;
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
    margin-top: 0.5rem;
    padding-left: 1rem;
}

.no-data {
    color: #9ca3af;
    text-align: center;
    padding: 3rem;
    font-style: italic;
}

/* Responsive */
@media (max-width: 768px) {
    .chart-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .filter-buttons {
        width: 100%;
        justify-content: center;
    }
    
    .chart-wrapper {
        flex-direction: column;
    }
    
    .y-axis-label {
        writing-mode: horizontal-tb;
        transform: none;
        margin-bottom: 1rem;
    }
    
    .chart-bars {
        flex-direction: column;
        align-items: stretch;
        min-height: auto;
        border-left: none;
        border-bottom: none;
        padding-left: 0;
    }
    
    .bar-container {
        height: 60px;
        align-items: center;
    }
    
    .bar {
        width: 100%;
        height: 40px !important;
        border-radius: 0 8px 8px 0;
        flex-direction: row;
        align-items: center;
        padding: 0 1rem;
    }
    
    .chart-item {
        margin-bottom: 1rem;
    }
    
    .bar-label {
        margin-top: 0.5rem;
    }
    
    .x-axis-label {
        padding-left: 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const chartContents = document.querySelectorAll('.chart-content');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const period = this.getAttribute('data-period');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update active chart
            chartContents.forEach(chart => chart.classList.remove('active'));
            document.getElementById(period + '-chart').classList.add('active');
        });
    });
});
</script>
@endsection
