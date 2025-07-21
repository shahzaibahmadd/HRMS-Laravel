@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Edit Payroll for {{ $user->name }}</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php
            $role = auth()->user()->getRoleNames()->first();
            $updateRoute = route("payroll." . strtolower($role) . ".update", $user->id);
        @endphp

        <form method="POST" action="{{ $updateRoute }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="basic_pay" class="form-label">Basic Pay</label>
                <input type="number" name="basic_pay" class="form-control" value="{{ old('basic_pay', $payroll->basic_pay) }}" required>
            </div>

            <div class="mb-3">
                <label for="bonuses" class="form-label">Bonuses</label>
                <input type="number" name="bonuses" class="form-control" value="{{ old('bonuses', $payroll->bonuses) }}">
            </div>

            <div class="mb-3">
                <label for="deductions" class="form-label">Deductions</label>
                <input type="number" name="deductions" class="form-control" value="{{ old('deductions', $payroll->deductions) }}">
            </div>

            <div class="mb-3">
                <label for="pay_date" class="form-label">Pay Date</label>
                <input type="date" name="pay_date" class="form-control" value="{{ old('pay_date', $payroll->pay_date) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Payroll</button>
        </form>
    </div>
@endsection
