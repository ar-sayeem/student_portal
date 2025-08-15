<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];

        // Add student-specific validation rules
        if ($this->user()->isStudent()) {
            $rules = array_merge($rules, [
                'student_id' => ['nullable', 'string', 'max:50'],
                'department' => ['nullable', 'string', 'max:255'],
                'session' => ['nullable', 'string', 'max:50'],
                'semester' => ['nullable', 'integer', 'min:1', 'max:12'],
                'phone' => ['nullable', 'string', 'max:20'],
                'address' => ['nullable', 'string', 'max:500'],
            ]);
        }

        return $rules;
    }
}
