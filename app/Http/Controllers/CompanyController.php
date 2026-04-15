<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();

        if ($request->has('q') && $request->q != '') {
            $searchTerm = $request->q;
            $query->where('name', 'ilike', '%' . $searchTerm . '%')
                  ->orWhere('description', 'ilike', '%' . $searchTerm . '%');
        }

        $companies = $query->orderBy('name', 'asc')->get();

        return view('companies.index', compact('companies'));
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
