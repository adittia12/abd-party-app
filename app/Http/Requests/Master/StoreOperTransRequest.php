<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperTransRequest extends FormRequest
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
            'tgl_opartional' => ['required', 'date'],
            'name_operational' => ['required', 'string'],
            'jenis_pemasukan' => ['required'],
            'budget' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'tgl_opartional' => [
                'required' => 'Tanggal Operasional Wajib diisi',
                'date' => 'Tanggal Operasional Harus dalam format tanggal'
            ],
            'name_operational' => [
                'required' => 'Nama Operasional Wajib diisi'
            ],
            'jenis_pemasukan' => [
                'required' => 'Jenis Pemasukan Wajib diisi'
            ],
            'budget' => [
                'required' => 'Budget Wajib diisi'
            ],
        ];
    }
}
