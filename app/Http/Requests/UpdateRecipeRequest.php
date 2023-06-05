<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('recipe'));
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'meal_type' => 'sometimes|string|max:255',
            'n_servings' => 'sometimes|integer',
            'prep_time' => 'sometimes|integer',
            'cook_time' => 'sometimes|integer',
            'description' => 'sometimes|string',
            'difficulty' => 'sometimes|integer',
            'cuisine' => 'sometimes|string|max:255',
            'instructions' => 'sometimes|array',
            'tips' => 'sometimes|array',
            'status' => 'sometimes|string|in:published,draft',
        ];
    }
}
