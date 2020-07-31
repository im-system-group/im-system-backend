<?php


namespace App\Http\Requests\Member;


use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'email' => 'string',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}