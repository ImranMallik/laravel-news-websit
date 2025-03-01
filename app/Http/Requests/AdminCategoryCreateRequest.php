<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCategoryCreateRequest extends FormRequest
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
        return [
            'language' => ['required', 'max:255', 'unique:categories,name,'],
            'show_at_nav' => ['required', 'boolean'],
            'name' => ['required'],
            'status' => ['required', 'boolean']
        ];
    }

    public function messages()
    {
        return [
            'language.required' => 'Language is required.',
            'name.required' => 'Category name is required.',
            'name.unique' => 'This category name already exists.',
            'show_at_nav.required' => 'Navigation visibility is required.',
            'status.required' => 'Status is required.',
        ];
    }
}
