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
