<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceAreaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'sa_code'  => 'nullable|string|max:50',
            'datel_id' => 'required|exists:datels,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama Service Area wajib diisi.',
            'name.max'          => 'Nama Service Area maksimal 255 karakter.',
            'sa_code.max'       => 'SA Code maksimal 50 karakter.',
            'datel_id.required' => 'Datel wajib dipilih.',
            'datel_id.exists'   => 'Datel yang dipilih tidak valid.',
        ];
    }
}
