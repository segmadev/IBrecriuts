<?php

namespace App\Http\Requests;

use App\Models\Services;
use Illuminate\Foundation\Http\FormRequest;

class CreateServicesRequest extends FormRequest
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
        return Services::$rules;
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'branding_slider.required' => 'The image field is required.',
        ];
    }
}
