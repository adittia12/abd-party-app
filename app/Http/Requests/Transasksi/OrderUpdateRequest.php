<?php

namespace App\Http\Requests\Transasksi;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'tgl_order'           => ['required', 'date'],
            'company_type'        => ['required'],
            'name_customer'       => ['required', 'string'],
            'invoice_address'     => ['required', 'string'],
            'delivery_address'    => ['required', 'string'],
            'start_event'         => ['required', 'date'],
            'end_event'           => ['required', 'date'],
            'id_product.*'          => ['required'],
            'description.*'         => ['required', 'string'],
            'qty.*'                   => ['required', 'numeric'],
            'price.*'                 => ['required', 'numeric'],
            'new_id_product.*'          => ['required'],
            'new_description.*'         => ['required', 'string'],
            'new_qty.*'                   => ['required', 'numeric'],
            'new_price.*'                 => ['required', 'numeric']
        ];
    }

    public function messages() : array
    {
        return [
            'tgl_order'   => [
                'required' => 'Tanggal order harus diisi',
                'date'     => 'Tanggal order harus dalam format tanggal'
            ],
            'company_type' => [
                'required' => 'Tipe perusahaan harus diisi',
            ],
            'name_customer' => [
                'required' => 'Nama customer harus diisi',
                'string'   => 'Nama customer harus dalam format text'
            ],
            'invoice_address' => [
                'required' => 'Alamat invoice harus diisi',
                'string'   => 'Alamat invoice harus dalam format text'
            ],
            'delivery_address' => [
                'required' => 'Alamat delivery harus diisi',
                'string'   => 'Alamat delivery harus dalam format text'
            ],
            'start_event' => [
                'required' => 'Tanggal mulai event harus diisi',
                'date'     => 'Tanggal mulai event harus dalam format tanggal'
            ],
            'end_event' => [
                'required' => 'Tanggal akhir event harus diisi',
                'date'     => 'Tanggal akhir event harus dalam format tanggal'
            ],
            'id_product.*' => [
                'required' => 'Produk harus diisi',
            ],
            'description.*' => [
                'required' => 'Deskripsi produk harus diisi',
                'string'   => 'Deskripsi produk harus dalam format text'
            ],
            'price.*' => [
                'required' => 'Harga produk harus diisi',
                'numeric'  => 'Harga produk harus dalam format angka'
            ],
            'qty.*' => [
                'required' => 'Jumlah produk harus diisi',
                'numeric'  => 'Jumlah produk harus dalam format angka'
            ],
            'new_id_product.*' => [
                'required' => 'Produk harus diisi',
            ],
            'new_description.*' => [
                'required' => 'Deskripsi produk harus diisi',
                'string'   => 'Deskripsi produk harus dalam format text'
            ],
            'new_price.*' => [
                'required' => 'Harga produk harus diisi',
                'numeric'  => 'Harga produk harus dalam format angka'
            ],
            'new_qty.*' => [
                'required' => 'Jumlah produk harus diisi',
                'numeric'  => 'Jumlah produk harus dalam format angka'
            ],
        ];
    }
}
