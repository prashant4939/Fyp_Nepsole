<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard - NepSole'); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            overflow-x: hidden;
        }

        .dashboard-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: white;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background: var(--navbar-color, #6366f1);
            color: white;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 0.5rem;
        }

        .sidebar-logo-icon {
            font-size: 24px;
        }

        .sidebar-logo-text {
            font-size: 20px;
            font-weight: 700;
        }

        .sidebar-title {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 500;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            padding: 0 1.5rem 0.5rem;
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 1.5rem;
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: #f9fafb;
            color: var(--navbar-color, #6366f1);
            border-left-color: var(--navbar-color, #6366f1);
        }

        .nav-link.active {
            background: #f0f9ff;
            color: var(--navbar-color, #6366f1);
            border-left-color: var(--navbar-color, #6366f1);
        }

        .nav-icon {
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
            background: white;
            display: none;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--navbar-color, #6366f1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-details h4 {
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .user-details p {
            font-size: 12px;
            color: #6b7280;
            text-transform: capitalize;
        }

        .logout-btn {
            width: 100%;
            background: #ef4444;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
        }

        .content-header {
            background: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-header h1 {
            color: #1f2937;
            font-size: 24px;
            font-weight: 600;
        }

        .header-user-menu {
            position: relative;
        }

        .user-menu-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-menu-trigger:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .user-menu-avatar {
            width: 32px;
            height: 32px;
            background: var(--navbar-color, #6366f1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-menu-name {
            font-weight: 500;
            color: #1f2937;
            font-size: 14px;
        }

        .user-menu-arrow {
            color: #6b7280;
            font-size: 12px;
            transition: transform 0.2s;
        }

        .user-menu-trigger.active .user-menu-arrow {
            transform: rotate(180deg);
        }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            display: none;
            z-index: 1000;
        }

        .user-dropdown.show {
            display: block;
        }

        .user-dropdown-header {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .user-dropdown-header h4 {
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .user-dropdown-header p {
            font-size: 12px;
            color: #6b7280;
            text-transform: capitalize;
        }

        .user-dropdown-menu {
            padding: 8px 0;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            color: #374151;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.2s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .user-dropdown-item:hover {
            background: #f9fafb;
        }

        .user-dropdown-item.danger {
            color: #ef4444;
        }

        .user-dropdown-item.danger:hover {
            background: #fef2f2;
        }

        .user-dropdown-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        .content-body {
            padding: 2rem;
        }

        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .welcome-card h2 {
            color: #1f2937;
            margin-bottom: 0.5rem;
            font-size: 1.75rem;
        }

        .welcome-card p {
            color: #6b7280;
            font-size: 1rem;
        }

        .role-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: var(--navbar-color, #6366f1);
            color: white;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block;
                background: var(--navbar-color, #6366f1);
                color: white;
                border: none;
                padding: 10px;
                border-radius: 6px;
                cursor: pointer;
                margin-bottom: 1rem;
            }
        }

        .mobile-menu-btn {
            display: none;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="dashboard-layout" style="--navbar-color: <?php echo $__env->yieldContent('navbar-color', '#6366f1'); ?>">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <div class="sidebar-logo-icon">🛍️</div>
                    <div class="sidebar-logo-text">NepSole</div>
                </div>
                <div class="sidebar-title"><?php echo $__env->yieldContent('panel-name', 'Dashboard'); ?></div>
            </div>

            <nav class="sidebar-nav">
                <?php echo $__env->yieldContent('sidebar-nav'); ?>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                    <div class="user-details">
                        <h4><?php echo e(auth()->user()->name); ?></h4>
                        <p><?php echo e(auth()->user()->role); ?></p>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(auth()->user()->role === 'admin' ? route('admin.logout') : route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <div>
                    <button class="mobile-menu-btn" onclick="toggleSidebar()">☰ Menu</button>
                    <h1><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                </div>
                
                <div class="header-user-menu">
                    <div class="user-menu-trigger" onclick="toggleUserMenu()">
                        <div class="user-menu-avatar">
                            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                        </div>
                        <span class="user-menu-name"><?php echo e(auth()->user()->name); ?></span>
                        <span class="user-menu-arrow">▼</span>
                    </div>
                    
                    <div class="user-dropdown" id="userDropdown">
                        <div class="user-dropdown-header">
                            <h4><?php echo e(auth()->user()->name); ?></h4>
                            <p><?php echo e(auth()->user()->role); ?></p>
                        </div>
                        <div class="user-dropdown-menu">
                            <a href="<?php echo e(route('profile.edit')); ?>" class="user-dropdown-item">
                                <span class="user-dropdown-icon">👤</span>
                                Edit Profile
                            </a>
                            <a href="<?php echo e(route('profile.password.edit')); ?>" class="user-dropdown-item">
                                <span class="user-dropdown-icon">🔒</span>
                                Change Password
                            </a>
                            <form method="POST" action="<?php echo e(auth()->user()->role === 'admin' ? route('admin.logout') : route('logout')); ?>" style="margin: 0;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="user-dropdown-item danger">
                                    <span class="user-dropdown-icon">🚪</span>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-body">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        }

        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            const trigger = document.querySelector('.user-menu-trigger');
            dropdown.classList.toggle('show');
            trigger.classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            const userMenu = document.querySelector('.header-user-menu');
            const dropdown = document.getElementById('userDropdown');
            
            // Close sidebar on mobile
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                menuBtn && !menuBtn.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
            
            // Close user dropdown when clicking outside
            if (userMenu && !userMenu.contains(event.target)) {
                dropdown.classList.remove('show');
                document.querySelector('.user-menu-trigger').classList.remove('active');
            }
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Krishna\Desktop\Fyp_Nepsole\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>