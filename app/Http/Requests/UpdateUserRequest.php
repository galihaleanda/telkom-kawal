<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user')->id;

        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,' . $userId,
            'jenis_kelamin' => 'required|string|in:Pria,Wanita',
            'posisi'        => 'required|string|max:255',
            'nik'           => 'required|string|min:6|unique:users,nik,' . $userId,
            'role'          => 'required|string|in:admin,viewer',
        ];
    }

    /**
     * Get custom Indonesian validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required'          => 'Nama lengkap wajib diisi.',
            'name.string'            => 'Nama lengkap harus berupa teks.',
            'name.max'               => 'Nama lengkap maksimal 255 karakter.',

            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.max'              => 'Email maksimal 255 karakter.',
            'email.unique'           => 'Email sudah digunakan oleh user lain.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin harus Pria atau Wanita.',

            'posisi.required'        => 'Posisi / jabatan wajib diisi.',
            'posisi.max'             => 'Posisi / jabatan maksimal 255 karakter.',

            'nik.required'           => 'NIK wajib diisi.',
            'nik.min'                => 'NIK minimal 6 karakter.',
            'nik.unique'             => 'NIK sudah digunakan oleh user lain.',

            'role.required'          => 'Role wajib dipilih.',
            'role.in'                => 'Role harus Admin atau Viewer.',
        ];
    }
}
