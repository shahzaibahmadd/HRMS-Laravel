<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        th {
            background-color: #007bff;
            color: #fff;
            padding: 8px;
            text-align: left;
            font-size: 18px;
        }
        td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e6f7ff;
        }
    </style>
</head>
<body>
<table>
    <tr><th colspan="2">Payslip</th></tr>
    <tr><td><strong>Name</strong></td><td>{{ $user->name }}</td></tr>
    <tr><td><strong>Email</strong></td><td>{{ $user->email }}</td></tr>
    <tr><td><strong>Basic Pay</strong></td><td>{{ $payroll->basic_pay }}</td></tr>
    <tr><td><strong>Bonuses</strong></td><td>{{ $payroll->bonuses }}</td></tr>
    <tr><td><strong>Deductions</strong></td><td>{{ $payroll->deductions }}</td></tr>
    <tr><td><strong>Net Salary</strong></td><td>{{ $payroll->net_salary }}</td></tr>
    <tr><td><strong>Pay Date</strong></td><td>{{ $payroll->pay_date }}</td></tr>
</table>
</body>
</html>
