<?php

namespace App\DTOs;

class EmployeeDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $email = null,
        public ?string $phone_number = null,
        public ?string $hire_date = null,
        public ?string $job_title = null,
        public ?float $salary = null,
        public ?string $profile_picture = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            email: $data['email'] ?? null,
            phone_number: $data['phone_number'] ?? null,
            hire_date: $data['hire_date'] ?? null,
            job_title: $data['job_title'] ?? null,
            salary: $data['salary'] ?? null,
            profile_picture: $data['profile_picture'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'hire_date' => $this->hire_date,
            'job_title' => $this->job_title,
            'salary' => $this->salary,
            'profile_picture' => $this->profile_picture,
        ], fn($value) => $value !== null);
    }
}

