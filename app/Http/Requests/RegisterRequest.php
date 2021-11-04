<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
            'themeColor' => 'required|string',
            'fontStyle' => 'required|string',
            'lightVersion' => 'required|boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'themeColor' => $this->get('themeColor') ?? "theme-cyan",
            'fontStyle' => $this->get('fontStyle') ?? "font-ubuntu",
            'lightVersion' => boolval($this->get('lightVersion')) ?? false,
        ]);
    }
}
