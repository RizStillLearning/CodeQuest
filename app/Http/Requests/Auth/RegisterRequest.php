<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Phones often capitalize the first letter of an email, so emails are
     * stored lowercase and compared lowercase.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'email' => mb_strtolower(trim((string) $this->input('email'))),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            // bcrypt only uses the first 72 bytes of a password.
            'password' => ['required', 'string', 'max:72', Password::defaults()],
            // Validated on its own field (instead of `confirmed`) so a mismatch
            // shows under "Ulangi kata sandi", where the learner needs to fix it.
            'password_confirmation' => ['required', 'string', 'same:password'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password_confirmation.same' => 'Kata sandi tidak cocok. Ketik ulang kata sandi yang sama.',
        ];
    }
}
