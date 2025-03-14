@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
    <div class="sidebar">
        <!-- Super Admin-specific navigation -->
    </div>
    <div class="main-content">
        @yield('dashboard-content')
    </div>
@endsection
