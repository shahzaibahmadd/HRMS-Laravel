<?php

namespace App\DTOs;

class AttendanceDTO
{
    public function __construct(
        public ?int $id = null,
        public ?int $employee_id = null,
        public ?string $check_in_time = null,
        public ?string $check_out_time = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            employee_id: $data['employee_id'] ?? null,
            check_in_time: $data['check_in_time'] ?? null,
            check_out_time: $data['check_out_time'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'check_in_time' => $this->check_in_time,
            'check_out_time' => $this->check_out_time,
        ], fn($value) => $value !== null);
    }
}

