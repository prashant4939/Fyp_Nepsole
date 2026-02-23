@extends('layouts.dashboard')

@section('title', 'Customer Dashboard - NepSole')
@section('panel-name', 'Customer Panel')
@section('navbar-color', '#f59e0b')

@section('content')
<div class="welcome-card">
    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p>You are logged in as a Customer.</p>
    <span class="role-badge">Customer</span>
</div>
@endsection
