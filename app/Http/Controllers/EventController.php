<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function index()
    {
        // Pega todos os eventos ordenados pela data e carrega a relação das inscrições do usuário logado
        $events = Event::with('creator')->orderBy('event_date', 'asc')->get();
        $userRegistrations = EventRegistration::where('user_id', Auth::id())->pluck('event_id')->toArray();

        return view('events.index', compact('events', 'userRegistrations'));
    }

    public function show(Event $event)
    {
        try {
            $event->load('creator', 'registrations', 'foodItems');
        } catch (QueryException $e) {
            Log::warning('Event show: failed to eager-load foodItems (maybe migration missing): '.$e->getMessage());
            $event->setRelation('foodItems', collect());
        }

        $userRegistrations = EventRegistration::where('user_id', Auth::id())->pluck('event_id')->toArray();

        return view('events.show', compact('event', 'userRegistrations'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'doador') {
            return redirect()->route('events.index')->with('info', 'Apenas doadores/empresas podem criar eventos.');
        }
        return view('events.create');
    }

    public function edit(Event $event)
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'doador' || $event->user_id !== $user->id) {
            return redirect()->route('events.index')->with('error', 'Ação não autorizada.');
        }

        return view('events.edit', compact('event'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'doador') {
            return redirect()->route('events.index')->with('info', 'Apenas doadores/empresas podem criar eventos.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        Event::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('events.index')->with('success', 'Evento criado com sucesso!');
    }

    public function update(Request $request, Event $event)
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'doador' || $event->user_id !== $user->id) {
            return redirect()->route('events.index')->with('error', 'Ação não autorizada.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $imagePath = $event->image_path;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('events.show', $event->id)->with('success', 'Evento atualizado com sucesso.');
    }

    public function register(Event $event)
    {
        $user = Auth::user();

        // Apenas recptores podem se inscrever
        if ($user->role !== 'receptor') {
            return redirect()->back()->with('info', 'Apenas usuários registrados como receptores podem se inscrever em eventos.');
        }

        // Evita inscrição duplicada
        if (!EventRegistration::where('event_id', $event->id)->where('user_id', $user->id)->exists()) {
            EventRegistration::create([
                'event_id' => $event->id,
                'user_id' => $user->id
            ]);
            return redirect()->back()->with('success', 'Inscrição realizada com sucesso!');
        }

        return redirect()->back()->with('info', 'Você já está inscrito neste evento.');
    }
}
