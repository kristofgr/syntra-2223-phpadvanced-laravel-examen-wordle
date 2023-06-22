<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $words = Word::all();
        return view('words.index', compact('words'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('words.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'word'=>'required',
        ]);

        $word = new Word([
            'word' => $request->get('word'),
            'scheduled_at' => date('Y-m-d'), // Currently using today's day, needs refactoring!
        ]);

        $word->save();
        return redirect('words')->with('success', 'Word saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $word = Word::find($id);
        return view('words.edit', compact('word')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'word'=>'required',
        ]);

        $word = Word::find($id);
        $word->word =  $request->get('word');
        $word->scheduled_at = date('Y-m-d'); // Currently using today's day, needs refactoring!

        $word->save();
        return redirect('/words')->with('success', 'Word updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $word = Word::find($id);
        $word->delete();
        return redirect('/words')->with('success', 'Word deleted!');
    }
}
