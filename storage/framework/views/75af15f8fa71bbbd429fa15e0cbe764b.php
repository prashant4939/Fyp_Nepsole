<footer class="footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="footer-logo">
                    <div class="logo-icon">🛍️</div>
                    <span class="logo-text">NepSole</span>
                </div>
                <p class="footer-tagline">Discover the finest Nepali footwear</p>
                <div class="social-links">
                    <a href="#" class="social-icon">📘</a>
                    <a href="#" class="social-icon">📷</a>
                    <a href="#" class="social-icon">🐦</a>
                    <a href="#" class="social-icon">💼</a>
                </div>
            </div>

            <div class="footer-section">
                <h4 class="footer-title">Company</h4>
                <ul class="footer-links">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Careers</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4 class="footer-title">Support</h4>
                <ul class="footer-links">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Shipping</a></li>
                    <li><a href="#">Returns</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4 class="footer-title">Legal</h4>
                <ul class="footer-links">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 NepSole. All rights reserved.</p>
        </div>
    </div>
</footer>

<style>
    .footer {
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        padding: 3rem 0 1.5rem;
        margin-top: 4rem;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .footer-content {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 3rem;
        margin-bottom: 2rem;
    }

    .footer-brand {
        max-width: 300px;
    }

    .footer-logo {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1rem;
    }

    .footer-logo .logo-icon {
        width: 32px;
        height: 32px;
        background: #6366f1;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .footer-logo .logo-text {
        font-size: 20px;
        font-weight: 700;
        color: #6366f1;
    }

    .footer-tagline {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 1.5rem;
    }

    .social-links {
        display: flex;
        gap: 1rem;
    }

    .social-icon {
        font-size: 20px;
        text-decoration: none;
        transition: transform 0.2s;
    }

    .social-icon:hover {
        transform: translateY(-2px);
    }

    .footer-title {
        color: #111827;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        color: #6b7280;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.2s;
    }

    .footer-links a:hover {
        color: #6366f1;
    }

    .footer-bottom {
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
        text-align: center;
    }

    .footer-bottom p {
        color: #9ca3af;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }
</style>
<?php /**PATH C:\Users\Krishna\Desktop\Fyp_Nepsole\resources\views/components/footer.blade.php ENDPATH**/ ?>