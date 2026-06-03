<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventFoodItem;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventFoodItemController extends Controller
{
    // Vincula um alimento ao evento
    public function store(Request $request, Event $event)
    {
        if (Auth::user()->role !== 'doador') {
            return redirect()->back()->with('error', 'Apenas doadores podem gerenciar alimentos do evento.');
        }

        $request->validate([
            'food_item_id' => 'required|exists:food_items,id',
        ]);

        // Evita duplicata
        EventFoodItem::firstOrCreate([
            'event_id'     => $event->id,
            'food_item_id' => $request->food_item_id,
        ], [
            'stock_status' => 'available',
        ]);

        return redirect()->back()->with('success', 'Alimento adicionado ao evento!');
    }

    // Atualiza o status do estoque
    public function updateStatus(Request $request, Event $event, FoodItem $foodItem)
    {
        if (Auth::user()->role !== 'doador') {
            return redirect()->back()->with('error', 'Apenas doadores podem alterar o status.');
        }

        $request->validate([
            'stock_status' => 'required|in:available,running_low,out_of_stock',
        ]);

        EventFoodItem::where('event_id', $event->id)
            ->where('food_item_id', $foodItem->id)
            ->update(['stock_status' => $request->stock_status]);

        return redirect()->back()->with('success', 'Status atualizado com sucesso!');
    }

    // Remove alimento do evento
    public function destroy(Event $event, FoodItem $foodItem)
    {
        if (Auth::user()->role !== 'doador') {
            return redirect()->back()->with('error', 'Apenas doadores podem remover alimentos do evento.');
        }

        EventFoodItem::where('event_id', $event->id)
            ->where('food_item_id', $foodItem->id)
            ->delete();

        return redirect()->back()->with('success', 'Alimento removido do evento.');
    }
}
