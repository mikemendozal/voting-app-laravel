<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptionStoreRequest;
use App\Http\Requests\OptionUpdateRequest;
use App\Models\Option;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Option/Index', [
            'options' => \App\Models\Option::with(['questions'])->get(),
            'questions' => \App\Models\Question::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OptionStoreRequest $request)
    {
        try {
            $validated = $request->validated();

            Option::create($validated);

            return to_route('options.index')->with('success', 'Opcion creada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al crear la opcion.');
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OptionUpdateRequest $request, Option $option)
    {
        try {
            $validated = $request->validated();

            $option->update($validated);

            return to_route('options.index')->with('success', 'Opcion actualizada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al actualizar la opcion.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
