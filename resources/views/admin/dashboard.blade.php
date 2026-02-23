@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - NepSole')
@section('panel-name', 'Admin Panel')
@section('navbar-color', '#6366f1')

@section('content')
<div class="welcome-card">
    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p>You are logged in as an Administrator.</p>
    <span class="role-badge">Admin</span>
</div>
@endsection
