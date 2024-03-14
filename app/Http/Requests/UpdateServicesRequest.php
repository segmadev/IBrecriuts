<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServicesRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'services_image' => 'nullable|mimes:jpeg,jpg,png',
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'services_image.required' => 'The image field is required.',
        ];
    }
}
