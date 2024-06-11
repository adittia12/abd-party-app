<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name_product'  => ['required', 'string'],
            'sales_price'   => ['required', 'numeric'],
            'unit_measure'  => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'name_product'  => [
                'string'    => 'Nama product wajib jenis text',
                'required'  => 'Nama Product wajib diisi'
            ],
            'sales_price'   => [
                'numeric'   => 'Sales price wajib bentuk angka',
                'required'  => 'Sales price wajib diisi'
            ],
            'unit_measure'  => [
                'string'    => 'Unit measure wajib bentuk text',
                'required'  => 'Unit measure wajib diisi'
            ]
        ];
    }
}
