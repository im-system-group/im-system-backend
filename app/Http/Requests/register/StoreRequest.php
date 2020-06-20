<?php

namespace App\Http\Requests\register;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account' => 'required|string|unique:members,account',
            'password' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|string'
        ];
    }
}
