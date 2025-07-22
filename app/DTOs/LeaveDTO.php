<?php

namespace App\DTOs;

class LeaveDTO
{
    public function __construct(
        public ?int $id = null,
        public ?int $employee_id = null,
        public ?string $leave_type = null,
        public ?string $start_date = null,
        public ?string $end_date = null,
        public ?string $reason = null,
        public ?string $status = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            employee_id: $data['employee_id'] ?? null,
            leave_type: $data['leave_type'] ?? null,
            start_date: $data['start_date'] ?? null,
            end_date: $data['end_date'] ?? null,
            reason: $data['reason'] ?? null,
            status: $data['status'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'leave_type' => $this->leave_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'reason' => $this->reason,
            'status' => $this->status,
        ], fn($value) => $value !== null);
    }
}

