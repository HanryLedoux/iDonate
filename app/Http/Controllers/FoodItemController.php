<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Event;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodItemController extends Controller
{
    public function create(Company $company)
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'doador' || ! $user->company || $user->company->id !== $company->id) {
            return redirect()->route('companies.show', $company->id)->with('error', 'Apenas o doador proprietário desta empresa pode adicionar alimentos.');
        }

        return view('food-items.create', compact('company'));
    }

    public function store(Request $request, Company $company)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'event_id' => 'nullable|exists:events,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('food_items', 'public');
        }

        $data = [
            'company_id' => $company->id,
            'title' => $request->title,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'image_path' => $imagePath,
            'is_available' => true,
        ];

        if ($request->filled('event_id')) {
            $data['event_id'] = $request->input('event_id');
        }

        FoodItem::create($data);

        return redirect()->route('companies.show', $company->id)->with('success', 'Alimento adicionado para doação com sucesso!');
    }

    public function show(FoodItem $foodItem)
    {
        $foodItem->load('company');
        return view('food-items.show', compact('foodItem'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        $user = Auth::user();

        if ($user->role !== 'doador') {
            return redirect()->back()->with('error', 'Ação não autorizada.');
        }

        // Allow update if user is owner of the company or owner of the event this item belongs to
        $isCompanyOwner = $foodItem->company && $foodItem->company->user_id === $user->id;
        $isEventOwner = $foodItem->event && $foodItem->event->user_id === $user->id;

        if (! $isCompanyOwner && ! $isEventOwner) {
            return redirect()->back()->with('error', 'Ação não autorizada.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:0',
            'is_available' => 'nullable|boolean',
        ]);

        $data = [
            'quantity' => (int) $request->input('quantity', $foodItem->quantity),
            'is_available' => $request->has('is_available') ? (bool) $request->boolean('is_available') : ($foodItem->quantity > 0 ? true : false),
        ];

        // If quantity is zero, ensure is_available is false
        if ($data['quantity'] <= 0) {
            $data['quantity'] = 0;
            $data['is_available'] = false;
        }

        $foodItem->update($data);

        return redirect()->back()->with('success', 'Alimento atualizado com sucesso.');
    }
}
