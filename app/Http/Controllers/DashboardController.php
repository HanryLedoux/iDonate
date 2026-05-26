<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Event;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'doador') {
            $foodItems = $user->company ? $user->company->foodItems()->orderBy('created_at', 'desc')->get() : collect();
            $myEvents = Event::where('user_id', $user->id)->orderBy('event_date', 'asc')->get();
            return view('dashboards.doador', compact('foodItems', 'myEvents'));
        } 
        elseif ($user->role === 'receptor') {
            $availableFoods = FoodItem::with('company')->where('is_available', true)->orderBy('created_at', 'desc')->get();
            $myRequests = Donation::with('foodItem.company')
                ->where('user_id', $user->id)
                ->where('status', '!=', 'cancelled')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            return view('dashboards.receptor', compact('availableFoods', 'myRequests'));
        } 
        elseif ($user->role === 'voluntario') {
            $upcomingEvents = Event::with('creator')->where('event_date', '>=', now())->orderBy('event_date', 'asc')->limit(6)->get();
            $myRegistrations = \App\Models\EventRegistration::with('event')->where('user_id', $user->id)->get();
            return view('dashboards.voluntario', compact('upcomingEvents', 'myRegistrations'));
        }

        // Fallback for an unknown role or admin
        return view('dashboard');
    }
}
