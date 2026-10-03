<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
   public function rules(): array
    {
        return [
            // Dua baris ini wajib ada agar data dari form tidak dibuang
            'code' => ['required', 'string', 'max:30', 'unique:activities,code'],
            'category_id' => ['required', 'exists:categories,id'],
            
            // Tiga baris ini adalah yang sudah berhasil lolos tadi
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'activity_date' => ['required', 'date'],
            'status' => ['required', 'in:Draft,Published,Completed'],
        ];
    }
}
