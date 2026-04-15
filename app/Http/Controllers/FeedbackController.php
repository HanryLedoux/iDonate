<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'message' => 'required|string|min:5'
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'message' => $request->message,
        ]);

        return redirect()->route('feedback.index')->with('status', 'feedback-sent');
    }
}
