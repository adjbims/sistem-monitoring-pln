<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change this to true if you want to authorize the request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,gif,pdf|max:2048', // Validate bukti_transfer field as required, image, maximum file size 2MB, and allowed file types are jpeg, png, jpg, and gif
            'tanggal' => 'required|date', // Validate tanggal field as required and must be a date
        ];
    }
}