<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users,email',
            'password'=>'required|string|min:6',
            'role'=>'required|string|exists:roles,name',
            'is_active'=>'nullable|boolean',
            'profile_image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'phone'         => 'required|string|max:255|unique:users,phone',
            'skills'        => 'nullable|string|max:500',
            'documents'     => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:51200',
            'resume'        => 'nullable|file|mimes:pdf,doc,docx|max:51200',
            'contract'      => 'nullable|file|mimes:pdf,doc,docx|max:51200',
        ];
    }
}
