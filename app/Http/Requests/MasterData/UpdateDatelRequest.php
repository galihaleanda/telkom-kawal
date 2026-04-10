<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDatelRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama Datel wajib diisi.',
            'name.max'           => 'Nama Datel maksimal 255 karakter.',
            'branch_id.required' => 'Branch wajib dipilih.',
            'branch_id.exists'   => 'Branch yang dipilih tidak valid.',
        ];
    }
}
