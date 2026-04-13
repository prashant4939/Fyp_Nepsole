@extends('layouts.app')

@section('title', 'About Us - NepSole')

@push('styles')
<style>
    /* ── Hero ── */
    .about-hero {
        background: linear-gradient(135deg, rgba(99,102,241,0.92), rgba(139,92,246,0.92)),
                    url('https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=1400') center/cover no-repeat;
        min-height: 420px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        padding: 4rem 2rem;
    }
    .about-hero h1 { font-size: 3rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.2; }
    .about-hero p  { font-size: 1.125rem; opacity: .9; max-width: 600px; margin: 0 auto; line-height: 1.7; }

    /* ── Shared ── */
    .section { max-width: 1100px; margin: 0 auto; padding: 5rem 2rem; }
    .section-label {
        display: inline-block;
        background: #ede9fe;
        color: #6366f1;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
        padding: 4px 14px;
        border-radius: 20px;
        margin-bottom: .75rem;
    }
    .section-title { font-size: 2rem; font-weight: 700; color: #111827; margin-bottom: 1rem; }
    .section-sub   { font-size: 1rem; color: #6b7280; line-height: 1.7; max-width: 640px; }
    .divider { border: none; border-top: 1px solid #f3f4f6; margin: 0; }

    /* ── Intro ── */
    .intro-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    .intro-img {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(99,102,241,.15);
    }
    .intro-img img { width: 100%; height: 360px; object-fit: cover; display: block; }
    .intro-text p  { color: #374151; line-height: 1.8; margin-bottom: 1rem; font-size: 15px; }
    .intro-stats {
        display: flex;
        gap: 2rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    .stat-item .num  { font-size: 2rem; font-weight: 800; color: #6366f1; }
    .stat-item .lbl  { font-size: 13px; color: #6b7280; margin-top: 2px; }

    /* ── Mission / Vision ── */
    .mv-section { background: #f9fafb; }
    .mv-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    .mv-card {
        background: #fff;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        border-top: 4px solid #6366f1;
    }
    .mv-card.vision { border-top-color: #8b5cf6; }
    .mv-card .icon  { font-size: 2.5rem; margin-bottom: 1rem; }
    .mv-card h3     { font-size: 1.25rem; font-weight: 700; color: #111827; margin-bottom: .75rem; }
    .mv-card p      { color: #6b7280; line-height: 1.7; font-size: 15px; }

    /* ── Features ── */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }
    .feature-card {
        background: #fff;
        border-radius: 14px;
        padding: 2rem 1.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.07);
        transition: transform .2s, box-shadow .2s;
        text-align: center;
    }
    .feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(99,102,241,.12); }
    .feature-card .icon { font-size: 2.5rem; margin-bottom: 1rem; }
    .feature-card h4    { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: .5rem; }
    .feature-card p     { font-size: 14px; color: #6b7280; line-height: 1.6; }

    /* ── Why Choose Us ── */
    .why-section { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
    .why-section .section-title { color: #fff; }
    .why-section .section-sub   { color: rgba(255,255,255,.8); }
    .why-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }
    .why-card {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 14px;
        padding: 2rem 1.5rem;
        text-align: center;
        color: #fff;
        backdrop-filter: blur(4px);
    }
    .why-card .icon { font-size: 2.25rem; margin-bottom: .75rem; }
    .why-card h4    { font-size: 1rem; font-weight: 700; margin-bottom: .5rem; }
    .why-card p     { font-size: 13px; opacity: .85; line-height: 1.6; }

    /* ── Team ── */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    .team-card {
        text-align: center;
        background: #fff;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.07);
        transition: transform .2s;
    }
    .team-card:hover { transform: translateY(-4px); }
    .team-avatar {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; color: #fff; font-weight: 700;
        margin: 0 auto 1rem;
    }
    .team-card h4   { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 4px; }
    .team-card span { font-size: 13px; color: #6b7280; }

    /* ── CTA ── */
    .cta-section { text-align: center; padding: 5rem 2rem; }
    .cta-section h2 { font-size: 2rem; font-weight: 700; color: #111827; margin-bottom: 1rem; }
    .cta-section p  { color: #6b7280; margin-bottom: 2rem; font-size: 15px; }
    .cta-btn {
        display: inline-block;
        padding: .875rem 2.5rem;
        background: #6366f1;
        color: #fff;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all .2s;
        margin: 0 .5rem;
    }
    .cta-btn:hover { background: #4f46e5; transform: translateY(-2px); }
    .cta-btn.outline {
        background: transparent;
        border: 2px solid #6366f1;
        color: #6366f1;
    }
    .cta-btn.outline:hover { background: #6366f1; color: #fff; }

    @media (max-width: 768px) {
        .about-hero h1 { font-size: 2rem; }
        .intro-grid, .mv-grid { grid-template-columns: 1fr; gap: 2rem; }
        .intro-img { display: none; }
    }
</style>
@endpush

@section('content')

{{-- ── Hero ── --}}
<section class="about-hero">
    <div>
        <h1>About NepSole</h1>
        <p>We're on a mission to bring the finest Nepali footwear to your doorstep — connecting talented local vendors with customers who value quality and heritage.</p>
    </div>
</section>

{{-- ── Introduction ── --}}
<div class="section">
    <div class="intro-grid">
        <div class="intro-img">
            <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=800" alt="NepSole Footwear">
        </div>
        <div class="intro-text">
            <span class="section-label">Our Story</span>
            <h2 class="section-title">Born from a Love of Nepali Craftsmanship</h2>
            <p>NepSole was founded with a simple idea — make it easy for people across Nepal (and beyond) to discover and buy authentic, high-quality footwear made by local artisans and brands.</p>
            <p>We built a multi-vendor marketplace where shoe vendors can list their products, manage orders, and grow their business — while customers enjoy a seamless, secure shopping experience.</p>
            <p>From traditional handcrafted sandals to modern sneakers, NepSole is your one-stop destination for footwear that tells a story.</p>
        </div>
    </div>
</div>

<hr class="divider">

{{-- ── Mission & Vision ── --}}
<div class="mv-section">
    <div class="section">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label">What Drives Us</span>
            <h2 class="section-title">Mission & Vision</h2>
        </div>
        <div class="mv-grid">
            <div class="mv-card">
                <div class="icon">🎯</div>
                <h3>Our Mission</h3>
                <p>To empower Nepali footwear vendors by providing a modern, easy-to-use platform that connects them with customers nationwide — while delivering a trustworthy and enjoyable shopping experience to every buyer.</p>
            </div>
            <div class="mv-card vision">
                <div class="icon">🔭</div>
                <h3>Our Vision</h3>
                <p>To become Nepal's leading footwear marketplace — a platform where local craftsmanship thrives, vendors grow their businesses, and customers always find the perfect pair of shoes at the right price.</p>
            </div>
        </div>
    </div>
</div>

<hr class="divider">

{{-- ── Why Choose Us ── --}}
<div class="why-section">
    <div class="section">
        <div style="text-align:center;">
            <span class="section-label" style="background:rgba(255,255,255,.2);color:#fff;">Why NepSole</span>
            <h2 class="section-title">Why Choose Us?</h2>
            <p class="section-sub" style="margin:0 auto;">We're not just another eCommerce site. Here's what makes NepSole different.</p>
        </div>
        <div class="why-grid">
            <div class="why-card">
                <div class="icon">🇳🇵</div>
                <h4>100% Nepali</h4>
                <p>Built for Nepal, by Nepalis. Every vendor and product is locally sourced and verified.</p>
            </div>
            <div class="why-card">
                <div class="icon">✅</div>
                <h4>Verified Vendors</h4>
                <p>All vendors go through an approval process. You only buy from trusted, vetted sellers.</p>
            </div>
            <div class="why-card">
                <div class="icon">💬</div>
                <h4>Real-Time Updates</h4>
                <p>Email notifications keep you informed at every step — from order placed to delivery.</p>
            </div>
            <div class="why-card">
                <div class="icon">💳</div>
                <h4>Flexible Payment</h4>
                <p>Choose between Khalti digital payment or Cash on Delivery — whatever works for you.</p>
            </div>
        </div>
    </div>
</div>

{{-- ── CTA ── --}}
<hr class="divider">
<div class="cta-section">
    <h2>Ready to explore NepSole?</h2>
    <p>Shop the latest Nepali footwear or apply to become a vendor today.</p>
    <a href="{{ route('products.index') }}" class="cta-btn">Shop Now</a>
    <a href="{{ route('vendor-request.create') }}" class="cta-btn outline">Become a Vendor</a>
</div>

@endsection
