<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'meal_type' => 'required|string|max:255',
            'n_servings' => 'required|integer',
            'prep_time' => 'required|integer',
            'cook_time' => 'required|integer',
            'description' => 'required|string',
            'difficulty' => 'required|integer',
            'cuisine' => 'required|string|max:255',
            'instructions' => 'required|array',
            'tips' => 'required|array',
            'status' => 'required|string|in:published,draft',
        ];
    }
}
