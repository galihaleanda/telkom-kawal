<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'witel_id' => 'required|exists:witels,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama Branch wajib diisi.',
            'name.max'          => 'Nama Branch maksimal 255 karakter.',
            'witel_id.required' => 'Witel wajib dipilih.',
            'witel_id.exists'   => 'Witel yang dipilih tidak valid.',
        ];
    }
}
