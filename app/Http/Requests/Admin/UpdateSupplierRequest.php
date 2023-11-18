<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
        $id = $this->route('supplier')->id;
        return [
            'name' => 'required',
            'email' => 'required|email|unique:suppliers,email,' . $id,
            'phone' => 'required|unique:suppliers,phone,' . $id,
            'address' => 'required',
        ];

    }
}
