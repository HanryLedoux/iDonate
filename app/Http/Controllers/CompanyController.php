<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Event;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();
        $foodItems = collect();
        $events = collect();

        if ($request->has('q') && $request->q != '') {
            $searchTerm = $request->q;

            $query->where('name', 'ilike', '%' . $searchTerm . '%')
                  ->orWhere('description', 'ilike', '%' . $searchTerm . '%');

            $foodItems = FoodItem::with('company')
                ->where('is_available', true)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'ilike', '%' . $searchTerm . '%')
                          ->orWhere('description', 'ilike', '%' . $searchTerm . '%');
                })
                ->orderBy('created_at', 'desc')
                ->get();

            $events = Event::where(function ($query) use ($searchTerm) {
                    $query->where('title', 'ilike', '%' . $searchTerm . '%')
                          ->orWhere('description', 'ilike', '%' . $searchTerm . '%')
                          ->orWhere('location', 'ilike', '%' . $searchTerm . '%');
                })
                ->orderBy('event_date', 'asc')
                ->get();
        }

        $companies = $query->orderBy('name', 'asc')->get();

        return view('companies.index', compact('companies', 'foodItems', 'events'));
    }

    public function show($id)
    {
        // View iFood style where you see the company banner/info and its food items
        $company = Company::with(['foodItems' => function($q) {
            $q->where('is_available', true)->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('companies.show', compact('company'));
    }
}
