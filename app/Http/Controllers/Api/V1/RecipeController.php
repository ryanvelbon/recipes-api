<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyRecipeRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('meal_type')) {
            $query->where('meal_type', $request->input('meal_type'));
        }

        if ($request->has('n_servings')) {
            $query->where('n_servings', $request->input('n_servings'));
        }

        if ($request->has('prep_time')) {
            $query->where('prep_time', '<=', $request->input('prep_time'));
        }

        if ($request->has('cook_time')) {
            $query->where('cook_time', '<=', $request->input('cook_time'));
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->input('description') . '%');
        }

        if ($request->has('difficulty')) {
            $query->where('difficulty', $request->input('difficulty'));
        }

        if ($request->has('cuisine')) {
            $query->where('cuisine', $request->input('cuisine'));
        }

        $recipes = $query->paginate(10);

        return RecipeResource::collection($recipes);
    }

    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe->load('user'));
    }

    public function store(StoreRecipeRequest $request)
    {
        $recipe = new Recipe($request->validated());

        $recipe->user_id = $request->user()->id;

        $recipe->save();

        return response()->json($recipe, 201);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipe->update($request->validated());

        return response()->json($recipe, 200);
    }

    public function destroy(DestroyRecipeRequest $request, Recipe $recipe)
    {
        $recipe->delete();

        return response()->json(null, 204);
    }
}
