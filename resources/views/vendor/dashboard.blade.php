@extends('layouts.dashboard')

@section('title', 'Vendor Dashboard - NepSole')
@section('panel-name', 'Vendor Panel')
@section('navbar-color', '#10b981')

@section('content')
<div class="welcome-card">
    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p>You are logged in as a Vendor.</p>
    <span class="role-badge">Vendor</span>
</div>
@endsection
