<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePegawaiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Assuming you have authorization logic in place, such as checking if the user has permission to update the Pegawai model.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //   get kelola-pegawai/{kelola_pegawai}/edit 
        $user_id = $this->route('kelola_pegawai');

        return [
            'tipe' => 'required|in:pegawai,tad',
            'nip' => $this->input('tipe') == 'tad' ? '' : 'required|string|max:255',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'min_transaksi' => 'nullable|numeric|min:0',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user_id->user_id,
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}
