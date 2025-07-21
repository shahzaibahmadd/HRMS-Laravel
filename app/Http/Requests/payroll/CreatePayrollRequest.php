<?php

namespace App\Http\Requests\payroll;

use Illuminate\Foundation\Http\FormRequest;

class CreatePayrollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('view payroll');    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'basic_pay' => ['required', 'numeric', 'min:0'],
            'bonuses' => ['nullable', 'numeric'],
            'deductions' => ['nullable', 'numeric'],
            'pay_date' => ['required', 'date'],
        ];
    }
}
