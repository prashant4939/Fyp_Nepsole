<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - NepSole')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
        }

        .dashboard-navbar {
            background: var(--navbar-color, #6366f1);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dashboard-nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-nav-container h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .logout-btn {
            background: white;
            color: var(--navbar-color, #6366f1);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
    </style>
    @stack('styles')
</head>
<body>
    <nav class="dashboard-navbar" style="--navbar-color: @yield('navbar-color', '#6366f1')">
        <div class="dashboard-nav-container">
            <h1>🛍️ NepSole - @yield('panel-name', 'Dashboard')</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </nav>
    
    <div class="dashboard-container">
        @yield('content')
    </div>
    
    @stack('scripts')
</body>
</html>
