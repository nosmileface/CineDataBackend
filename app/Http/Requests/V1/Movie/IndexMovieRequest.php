<?php

namespace App\Http\Requests\V1\Movie;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexMovieRequest extends FormRequest
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
            'perPage' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'page' => ['sometimes', 'integer', 'min:1']
        ];
    }

    public function messages(): array
    {
        return [
            'sort.string' => 'Параметр "sort" должен быть строкой.',
            'sort.in' => 'Недопустимое значение параметра "sort".',

            'perPage.integer' => 'Параметр "perPage" должен быть числом.',
            'perPage.min' => 'Параметр "perPage" должен быть не меньше 1.',
            'perPage.max' => 'Параметр "perPage" не может быть больше 100.',

            'page.integer' => 'Параметр "page" должен быть числом.',
            'page.min' => 'Параметр "page" должен быть не меньше 1.'
        ];
    }
}
