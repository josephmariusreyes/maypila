<?php

namespace App\Http\Requests\User;

use App\Enum\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->input('id');
        $emailRule = 'required|email|unique:users,email';

        if ($userId) {
            $emailRule .= ',' . $userId;
        }
        return [
            'id' => ['sometimes', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => $emailRule,
            'password' => $userId
                ? ['nullable', 'string', 'min:8']
                : ['required', 'string', 'min:8'],
            'mobile_number' => ['required', 'digits:10'],
            'company_id' => ['required', 'integer'],
            'role' => ['required', Rule::in(array_map(fn (UserRole $role) => $role->value, UserRole::cases()))],
        ];
    }
}
