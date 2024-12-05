<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreEmploye extends FormRequest
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
            'id_group' => ['required'],
            'name'     => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'id_group.required' => 'Group wajib diisi',
            'name.required'     => 'Nama karyawan wajib diisi'
        ];
    }
}
