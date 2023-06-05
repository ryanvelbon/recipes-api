<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => new UserResource($this->whenLoaded('user')),
            'meal_type' => $this->meal_type,
            'n_servings' => $this->n_servings,
            'prep_time' => $this->prep_time,
            'cook_time' => $this->cook_time,
            'description' => $this->description,
            'difficulty' => $this->difficulty,
            'cuisine' => $this->cuisine,
            'instructions' => $this->instructions,
            'tips' => $this->tips,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
