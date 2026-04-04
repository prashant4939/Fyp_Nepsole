<?php $__env->startSection('title', 'Vendor Dashboard - NepSole'); ?>
<?php $__env->startSection('panel-name', 'Vendor Panel'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('navbar-color', '#10b981'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php echo $__env->make('vendor.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="welcome-card">
    <h2>Welcome, <?php echo e(auth()->user()->name); ?>!</h2>
    <p>You are logged in as a Vendor.</p>
    <span class="role-badge">Vendor</span>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-content">
            <h3>Total Orders</h3>
            <p class="stat-number"><?php echo e($totalOrders); ?></p>
            <span class="stat-label">Order Items</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">🛍️</div>
        <div class="stat-content">
            <h3>Products Owned</h3>
            <p class="stat-number"><?php echo e($totalProducts); ?></p>
            <span class="stat-label">Your Products</span>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="revenue-section">
    <div class="chart-header">
        <h2 class="section-title">Revenue Analytics</h2>
        <div class="filter-buttons">
            <button class="filter-btn active" data-period="weekly">Weekly</button>
            <button class="filter-btn" data-period="monthly">Monthly</button>
            <button class="filter-btn" data-period="yearly">Yearly</button>
        </div>
    </div>
    
    <div class="chart-container">
        <div id="weekly-chart" class="chart-content active">
            <h3 class="chart-subtitle">Last 7 Days</h3>
            <div class="chart-wrapper">
                <div class="y-axis-label">Revenue (Rs.)</div>
                <div class="chart-area">
                    <div class="revenue-display">
                        <div class="revenue-bar-container">
                            <div class="revenue-bar revenue-bar-weekly" style="width: 100%">
                                <span class="revenue-value">Rs. <?php echo e(number_format($revenueData['weekly'], 2)); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="x-axis-label">Time Period</div>
                </div>
            </div>
        </div>
        
        <div id="monthly-chart" class="chart-content">
            <h3 class="chart-subtitle">Last 30 Days</h3>
            <div class="chart-wrapper">
                <div class="y-axis-label">Revenue (Rs.)</div>
                <div class="chart-area">
                    <div class="revenue-display">
                        <div class="revenue-bar-container">
                            <div class="revenue-bar revenue-bar-monthly" style="width: 100%">
                                <span class="revenue-value">Rs. <?php echo e(number_format($revenueData['monthly'], 2)); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="x-axis-label">Time Period</div>
                </div>
            </div>
        </div>
        
        <div id="yearly-chart" class="chart-content">
            <h3 class="chart-subtitle">Last 365 Days</h3>
            <div class="chart-wrapper">
                <div class="y-axis-label">Revenue (Rs.)</div>
                <div class="chart-area">
                    <div class="revenue-display">
                        <div class="revenue-bar-container">
                            <div class="revenue-bar revenue-bar-yearly" style="width: 100%">
                                <span class="revenue-value">Rs. <?php echo e(number_format($revenueData['yearly'], 2)); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="x-axis-label">Time Period</div>
                </div>
            </div>
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
    background: #10b981;
    color: white;
}

.chart-container {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

.revenue-display {
    border-left: 2px solid #e5e7eb;
    border-bottom: 2px solid #e5e7eb;
    padding: 2rem 1rem;
    min-height: 200px;
    display: flex;
    align-items: center;
}

.revenue-bar-container {
    width: 100%;
}

.revenue-bar {
    height: 80px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.revenue-bar-weekly {
    background: linear-gradient(to right, #10b981, #34d399);
}

.revenue-bar-monthly {
    background: linear-gradient(to right, #3b82f6, #60a5fa);
}

.revenue-bar-yearly {
    background: linear-gradient(to right, #f59e0b, #fbbf24);
}

.revenue-value {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
}

.x-axis-label {
    color: #4b5563;
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
    margin-top: 0.5rem;
    padding-left: 1rem;
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/vendor/dashboard.blade.php ENDPATH**/ ?>