<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "username" => ["required"],
            "password" => ["required"],
        ];
    }

    public function prepareForValidation(): void{
        $this->merge([
            "username" => strtolower($this->input("username"))
        ]);
    }

    public function passedValidation(): void{
        $this->merge([
            "password" => bcrypt($this->input("password"))
        ]);
    }
}
