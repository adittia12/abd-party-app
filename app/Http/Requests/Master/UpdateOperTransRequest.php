<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperTransRequest extends FormRequest
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
            'name_operational' => ['required', 'string'],
            'budget' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'name_operational' => [
                'required' => 'Nama Operasional Wajib diisi'
            ],
            'budget' => [
                'required' => 'Budget Wajib diisi'
            ],
        ];
    }
}
