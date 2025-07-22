<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return auth()->user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|string|unique:users,phone,' . $this->user->id,
            'is_active' => 'required|boolean',
            'role' => 'required|in:Admin,HR,Manager,Employee',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
            'skills'        => 'nullable|string|max:500',
            'documents'     => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:5120',
            'resume'        => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'contract'      => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];
    }
}
