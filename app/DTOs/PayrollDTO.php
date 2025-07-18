<?php

namespace App\DTOs;

class PayrollDTO
{
    public function __construct(
        public readonly int $user_id,
        public readonly float $basic_pay,
        public readonly float $bonuses,
        public readonly float $deductions,
        public readonly string $pay_date,
    ) {}

    public function toArray(): array
    {
        $net_salary = $this->basic_pay + $this->bonuses - $this->deductions;

        return [
            'user_id' => $this->user_id,
            'basic_pay' => $this->basic_pay,
            'bonuses' => $this->bonuses,
            'deductions' => $this->deductions,
            'net_salary' => $net_salary,
            'pay_date' => $this->pay_date,
        ];
    }
}
