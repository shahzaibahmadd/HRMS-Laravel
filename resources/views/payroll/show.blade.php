@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Payroll Details for {{ $user->name }}</h3>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if(isset($payroll))
            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>Basic Pay:</strong> {{ $payroll->basic_pay }}</li>
                <li class="list-group-item"><strong>Bonuses:</strong> {{ $payroll->bonuses }}</li>
                <li class="list-group-item"><strong>Deductions:</strong> {{ $payroll->deductions }}</li>
                <li class="list-group-item"><strong>Net Salary:</strong> {{ $payroll->net_salary }}</li>
                <li class="list-group-item"><strong>Pay Date:</strong> {{ $payroll->pay_date }}</li>
            </ul>

            {{-- Generate Payslip Button --}}
            <form action="{{ route('payslips.generate', $payroll->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Generate Latest Payslip</button>
            </form>

            {{-- Show download button if payslip exists --}}
            @if($payroll->payslip)
                <div class="mt-3">
                    <a href="{{ route('payslips.download', $payroll->payslip->id) }}" class="btn btn-success">
                        Download Latest Payslip
                    </a>
                </div>
            @endif

        @else
            <p>No payroll record available.</p>
        @endif
    </div>

@endsection
