<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        $myDonations = Donation::with(['foodItem.company', 'receiver'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('donations.index', compact('myDonations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'food_item_id' => 'required|exists:food_items,id'
        ]);

        $foodItem = FoodItem::findOrFail($request->food_item_id);

        if ($foodItem->quantity < 1) {
            return redirect()->back()->with('error', 'Este alimento não está mais disponível.');
        }

        Donation::create([
            'food_item_id' => $foodItem->id,
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        // Deduz quantidade. Em um app real deveríamos bloquear a quantidade ao aprovar apenas, ou aqui.
        $foodItem->decrement('quantity');
        if ($foodItem->quantity === 0) {
            $foodItem->update(['is_available' => false]);
        }

        return redirect()->route('donations.index')->with('success', 'Solicitação de doação enviada com sucesso!');
    }
}
