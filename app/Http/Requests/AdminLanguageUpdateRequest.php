<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLanguageUpdateRequest extends FormRequest
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
        // $langId = $this->route('language');
        return [
            'language' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string'],
            'status' => ['required', 'in:0,1'],
            'default' => ['required', 'in:0,1'],
        ];
    }
}
