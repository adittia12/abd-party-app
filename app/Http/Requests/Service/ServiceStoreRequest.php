<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceStoreRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'name_photo' => ['mimes:png,jpg', 'max:2048']
        ];
    }

    public function messages(): array
    {
        return [
            'title' => [
                'required' => 'Nama Pelayanan wajib diisi!',
                'string' => 'Nama Pelayanan harus berupa string!',
            ],
            'description' => [
                'required' => 'Deskripsi Pelayanan wajib diisi!',
                'string' => 'Deskripsi Pelayanan harus berupa string!',
            ],
            'name_photo' => [
                'mimes' => 'Foto Pelayanan hanya dapat berupa file PNG atau JPG!',
                'max' => 'Ukuran Foto Pelayanan tidak boleh melebihi 2Mb'
            ]
        ];
    }
}
