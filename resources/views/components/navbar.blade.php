<nav class="navbar">
    <div class="nav-container">
        <div class="nav-left">
            <a href="/" class="logo">
                <div class="logo-icon">🛍️</div>
                <span class="logo-text">NepSole</span>
            </a>
            <div class="nav-links">
                <a href="/" class="nav-link">Home</a>
                <a href="#" class="nav-link">Shop</a>
                <a href="#" class="nav-link">Categories</a>
            </div>
        </div>
        <div class="nav-right">
            <a href="#" class="nav-icon">🛒</a>
            @guest
                <a href="{{ route('login') }}" class="nav-btn-outline">Login</a>
                <a href="{{ route('register') }}" class="nav-btn-primary">Sign Up</a>
            @else
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="nav-btn-outline">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-btn-outline" style="background: transparent; cursor: pointer;">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>

<style>
    .navbar {
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1rem 0;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-left {
        display: flex;
        align-items: center;
        gap: 3rem;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .logo-icon {
        width: 32px;
        height: 32px;
        background: #6366f1;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .logo-text {
        font-size: 20px;
        font-weight: 700;
        color: #6366f1;
    }

    .nav-links {
        display: flex;
        gap: 2rem;
    }

    .nav-link {
        color: #374151;
        text-decoration: none;
        font-weight: 500;
        font-size: 15px;
        transition: color 0.2s;
    }

    .nav-link:hover {
        color: #6366f1;
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .nav-icon {
        font-size: 20px;
        text-decoration: none;
        padding: 0.5rem;
    }

    .nav-btn-outline {
        padding: 0.5rem 1.25rem;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        text-decoration: none;
        color: #374151;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s;
    }

    .nav-btn-outline:hover {
        border-color: #6366f1;
        color: #6366f1;
    }

    .nav-btn-primary {
        padding: 0.5rem 1.25rem;
        background: #6366f1;
        border-radius: 6px;
        text-decoration: none;
        color: white;
        font-weight: 500;
        font-size: 14px;
        transition: background 0.2s;
    }

    .nav-btn-primary:hover {
        background: #4f46e5;
    }

    @media (max-width: 768px) {
        .nav-links {
            display: none;
        }
    }
</style>
