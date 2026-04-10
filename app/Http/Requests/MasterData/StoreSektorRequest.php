<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class StoreSektorRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'service_area_id' => 'required|exists:service_areas,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'            => 'Nama Sektor wajib diisi.',
            'name.max'                 => 'Nama Sektor maksimal 255 karakter.',
            'service_area_id.required' => 'Service Area wajib dipilih.',
            'service_area_id.exists'   => 'Service Area yang dipilih tidak valid.',
        ];
    }
}
