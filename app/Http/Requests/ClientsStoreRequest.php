<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientsStoreRequest extends FormRequest
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
            'client_name' => ['required', 'string'],
            'image' => ['required', 'mimes:png,jpg', 'max:2048']
        ];
    }

    public function messages(): array
    {
        return [
            'client_name' => [
                'required' => 'Nama Perusahaan wajib diisi!!',
                'string' => 'Nama perusahaan wajib bentuk text.'
            ],
            'image' => [
                'required' => 'Logo perusahaan wajib diisi!!',
                'mimes' => 'Logo perusahaan hanya dapat berupa file png atau jpg.',
                'max' => 'Ukuran logo perusahaan tidak boleh melebihi 2Mb.'
            ]
        ];
    }
}
