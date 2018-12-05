<?php

namespace App\Http\Requests\Backend\Auth\Role;

use App\Rules\Auth\ChangePassword;
use App\Rules\Auth\UnusedPassword;
use DivineOmega\LaravelPasswordExposedValidationRule\PasswordExposed;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class DoctorRequest.
 */
class DoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if ($this->isMethod('POST')) {
            $rules = [
                'first_name' => ['required', 'max:191'],
                'last_name' => ['required', 'max:191'],
                'email' => ['required', 'email', 'max:191', Rule::unique('users')],
                'password' => ['required', 'min:6', 'confirmed'],
            ];
        } elseif ($this->isMethod('PATCH') or $this->isMethod('PUT')) {
            $rules = [
                'first_name' => ['required', 'max:191'],
                'last_name' => ['required', 'max:191'],
                'email' => ['required', 'email', 'max:191', 'unique:users,email,' . $this->doctor->id],
            ];

            if (isCurrentUser($this->doctor->id)) {
                $rules['password'] = [
                    'required',
                    'confirmed',
                ];
            }

        }
        return $rules;
    }
}
