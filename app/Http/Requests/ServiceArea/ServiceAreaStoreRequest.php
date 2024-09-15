<?php

namespace App\Http\Requests\ServiceArea;

use Illuminate\Foundation\Http\FormRequest;

class ServiceAreaStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'area' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'area' => [
                'required' => 'Nama wilayah wajib diisi!',
                'string' => 'Nama wilayah wajib bentuk text!'
            ]
        ];
    }
}
