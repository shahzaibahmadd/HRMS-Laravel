@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Employee Dashboard - Viewing {{ $user->name }}</h1>

        <p>Email: {{ $user->email }}</p>
        <p>Phone: {{ $user->phone }}</p>
        <p>Status: {{ $user->is_active ? 'Active' : 'Inactive' }}</p>

        @if($user->profile_image)
            <img src="{{ asset('storage/user_images/' . $user->profile_image) }}" alt="Profile Image" width="150">
        @endif
    </div>
@endsection
