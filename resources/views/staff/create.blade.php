@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center text-primary">Add Staff Member</h2>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('staff.store') }}" class="mt-3">
            @csrf

            <div class="mb-3">
                <label for="reg_no" class="form-label">Register Number:</label>
                <input type="text" class="form-control" name="reg_no" required>
            </div>

            <div class="mb-3">
                <label for="user_name" class="form-label">Username:</label>
                <input type="text" class="form-control" name="user_name" required>
            </div>

            <div class="mb-3">
                <label for="service_number" class="form-label">Service Number:</label>
                <input type="text" class="form-control" name="service_number" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Add Staff</button>
        </form>
    </div>
</div>
@endsection