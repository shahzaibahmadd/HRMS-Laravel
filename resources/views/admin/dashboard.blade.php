@extends('layouts.app')

@section('admin')
    @include('layouts.admin')
@endsection

@section('content')
    <div class="container">
        <h2 class="mb-3">Admin Dashboard</h2>
        <p>Welcome, Admin! You have full control over the HR Management System.</p>

        <ul>
            <li>Manage all users and roles</li>
            <li>Access all dashboards (HR, Manager, Employee)</li>
            <li>View logs and settings</li>
        </ul>
    </div>
@endsection
