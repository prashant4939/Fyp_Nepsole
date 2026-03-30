@extends('layouts.auth')

@section('title', 'Verify Email - NepSole')

@section('content')
<div class="auth-title">Verify Your Email</div>

@if (session('status'))
    <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
        {{ session('status') }}
    </div>
@endif

<div style="text-align: center; margin-bottom: 24px;">
    <div style="font-size: 48px; margin-bottom: 16px;">📧</div>
    <p style="color: #6b7280; font-size: 14px; line-height: 1.6;">
        Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
    </p>
    <p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin-top: 12px;">
        <strong>{{ auth()->user()->email }}</strong>
    </p>
</div>

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="btn-primary">Resend Verification Email</button>
</form>

<div class="auth-footer">
    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit" style="background: none; border: none; color: #6366f1; text-decoration: underline; cursor: pointer; font-size: 14px;">
            Logout
        </button>
    </form>
</div>

<style>
    .info-box {
        background: #dbeafe;
        color: #1e40af;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13px;
        text-align: center;
    }
</style>

<div class="info-box">
    ℹ️ If you didn't receive the email, click the button above to resend.
</div>
@endsection
