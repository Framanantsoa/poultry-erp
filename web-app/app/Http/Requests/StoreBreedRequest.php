<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBreedRequest extends FormRequest
{
    public function authorize(): bool {
        return $this->user()->can('breeds.create');
    }

    public function rules(): array {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:breeds,name'],
            'chick_cost' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'The breed name is required.',
            'name.unique' => 'A breed with this name already exists.',
            'chick_cost.required' => 'The chick cost is required.',
            'chick_cost.min' => 'The chick cost cannot be negative.',
        ];
    }
}
