<?php

namespace App\Http\Controllers;

use App\Models\Help;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        $helps = Help::all();
        return view('helps.index', compact('helps'));
    }

    public function create()
    {
        return view('helps.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
        ]);

        Help::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
        ]);

        return redirect()->route('helps.index')->with('success', 'Ayuda creada correctamente');
    }

    public function show(Help $help)
    {
        return view('helps.show', compact('help'));
    }

    public function edit(Help $help)
    {
        return view('helps.edit', compact('help'));
    }

    public function update(Request $request, Help $help)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
        ]);

        $help->update([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
        ]);

        return redirect()->route('helps.index')->with('success', 'Ayuda actualizada correctamente');
    }

    public function destroy(Help $help)
    {
        $help->delete();
        return redirect()->route('helps.index')->with('success', 'Ayuda eliminada correctamente');
    }
}
