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
        $user = Auth::user();

        if ($user->role === 'doador') {
            $company = $user->company;
            if (!$company) {
                $myDonations = collect();
            } else {
                $myDonations = Donation::with(['foodItem.company', 'receiver'])
                    ->whereHas('foodItem', function ($q) use ($company) {
                        $q->where('company_id', $company->id);
                    })
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } else {
            $myDonations = Donation::with(['foodItem.company', 'receiver'])
                ->where('user_id', Auth::id())
                ->where('status', '!=', 'cancelled')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('donations.index', compact('myDonations'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'receptor') {
            return redirect()->back()->with('error', 'Apenas usuários do tipo Receptor podem solicitar alimentos.');
        }

        $request->validate([
            'food_item_id' => 'required|exists:food_items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $foodItem = FoodItem::findOrFail($request->food_item_id);

        $qty = (int) $request->quantity;

        if ($foodItem->quantity < $qty) {
            return redirect()->back()->with('error', 'Quantidade solicitada maior do que a disponível.');
        }

        $donation = Donation::create([
            'food_item_id' => $foodItem->id,
            'user_id' => Auth::id(),
            'status' => 'pending',
            'quantity' => $qty,
        ]);

        // Deduz quantidade reservada
        $foodItem->decrement('quantity', $qty);
        if ($foodItem->quantity <= 0) {
            $foodItem->update(['is_available' => false, 'quantity' => 0]);
        }

        return redirect()->route('donations.index')->with('success', 'Solicitação de doação enviada com sucesso!');
    }

    public function destroy(Donation $donation)
    {
        $user = Auth::user();

        // Only the receiver who created the request can cancel it
        if ((int) $user->id !== (int) $donation->user_id) {
            return redirect()->back()->with('error', 'Ação não autorizada.');
        }

        // Only pending requests can be cancelled
        if ($donation->status !== 'pending') {
            return redirect()->back()->with('error', 'Apenas pedidos pendentes podem ser cancelados.');
        }

        // Restore quantity back to the food item
        $foodItem = $donation->foodItem;
        if ($foodItem) {
            $foodItem->increment('quantity', $donation->quantity ?? 1);
            if ($foodItem->quantity > 0 && !$foodItem->is_available) {
                $foodItem->update(['is_available' => true]);
            }
        }

        $donation->update(['status' => 'cancelled']);

        return redirect()->route('donations.index')->with('success', 'Pedido cancelado com sucesso.');
    }

    /**
     * Cancel donation via POST (JSON) — helper for browser tests.
     */
    public function cancel(Request $request, Donation $donation)
    {
        $user = Auth::user();

        if ((int) $user->id !== (int) $donation->user_id) {
            return response()->json(['error' => 'Ação não autorizada.'], 403);
        }

        if ($donation->status !== 'pending') {
            return response()->json(['error' => 'Apenas pedidos pendentes podem ser cancelados.'], 400);
        }

        $foodItem = $donation->foodItem;
        if ($foodItem) {
            $foodItem->increment('quantity', $donation->quantity ?? 1);
            if ($foodItem->quantity > 0 && !$foodItem->is_available) {
                $foodItem->update(['is_available' => true]);
            }
        }

        $donation->update(['status' => 'cancelled']);

        return response()->json(['success' => true]);
    }

    /**
     * Partially cancel a donation quantity via POST (JSON)
     */
    public function partialCancel(Request $request, Donation $donation)
    {
        $user = Auth::user();

        if ((int) $user->id !== (int) $donation->user_id) {
            return response()->json(['error' => 'Ação não autorizada.'], 403);
        }

        if ($donation->status !== 'pending') {
            return response()->json(['error' => 'Apenas pedidos pendentes podem ser cancelados.'], 400);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $qty = (int) $request->input('quantity');
        $current = (int) ($donation->quantity ?? 1);

        if ($qty > $current) {
            return response()->json(['error' => 'Quantidade inválida.'], 400);
        }

        $foodItem = $donation->foodItem;
        if ($foodItem) {
            $foodItem->increment('quantity', $qty);
            if ($foodItem->quantity > 0 && !$foodItem->is_available) {
                $foodItem->update(['is_available' => true]);
            }
        }

        $remaining = $current - $qty;
        if ($remaining <= 0) {
            $donation->update(['status' => 'cancelled', 'quantity' => 0]);
        } else {
            $donation->update(['quantity' => $remaining]);
        }

        return response()->json(['success' => true, 'remaining_quantity' => $remaining]);
    }
}
