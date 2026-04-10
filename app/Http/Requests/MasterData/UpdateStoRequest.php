<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'code'      => 'required|string|max:50',
            'name'      => 'nullable|string|max:255',
            'sektor_id' => 'required|exists:sektors,id',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required'      => 'Kode STO wajib diisi.',
            'code.max'           => 'Kode STO maksimal 50 karakter.',
            'name.max'           => 'Nama STO maksimal 255 karakter.',
            'sektor_id.required' => 'Sektor wajib dipilih.',
            'sektor_id.exists'   => 'Sektor yang dipilih tidak valid.',
        ];
    }
}
