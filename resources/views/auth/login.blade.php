@extends('layouts.app')

@section('content')
    <div class="row justify-content-center fade-in">
        <div class="col-md-5">
            <div class="card shadow-lg border-0" style="background-color: rgba(255,255,255,0.05); backdrop-filter: blur(10px); color: white;">
                <div class="card-header bg-transparent border-0 text-center">
                    <h4 class="fw-bold">Login to HRMS</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input id="email" type="email"
                                   class="form-control bg-light bg-opacity-10 text-white @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                            <span class="invalid-feedback d-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password"
                                   class="form-control bg-light bg-opacity-10 text-white @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                            <span class="invalid-feedback d-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-light w-100 fw-semibold text-primary">
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
