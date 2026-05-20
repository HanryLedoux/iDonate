<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    public function create(Company $company)
    {
        return view('food-items.create', compact('company'));
    }

    public function store(Request $request, Company $company)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('food_items', 'public');
        }

        FoodItem::create([
            'company_id' => $company->id,
            'title' => $request->title,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'image_path' => $imagePath,
            'is_available' => true,
        ]);

        return redirect()->route('companies.show', $company->id)->with('success', 'Alimento adicionado para doação com sucesso!');
    }

    public function show(FoodItem $foodItem)
    {
        $foodItem->load('company');
        return view('food-items.show', compact('foodItem'));
    }
}
