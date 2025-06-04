<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Models\Question;
use Inertia\Inertia;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Question/Index', [
            'questions' => \App\Models\Question::with(['creator', 'updater', 'options'])->get(),
            'options' => \App\Models\Option::all(),
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
    public function store(QuestionStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['created_by'] = auth()->id(); // <- Aquí se asigna el usuario actual

            $question = Question::create($validated);

            // Crear las opciones (nuevas o existentes)
            foreach ($validated['options'] as $optionData) {
                // Si tiene ID, es una opción existente que debemos asociar
                if (isset($optionData['id'])) {
                    $question->options()->attach($optionData['id']);
                } else {
                    // Es una nueva opción que debemos crear
                    $question->options()->create([
                        'content' => $optionData['content']
                    ]);
                }
            }

            return to_route('questions.index')->with('success', 'Pregunta creada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al crear la pregunta.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return Inertia::render('Question/Show', [
            'question' => $question::with(['creator', 'updater'])->find($question->id),
        ]);
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
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        try {
            $validated = $request->validated();
            $validated['updated_by'] = auth()->id();

            // Actualiza la pregunta
            $question->update($validated);

            // Procesar opciones
            $incomingOptions = collect($validated['options']);
            $optionsToSync = [];

            foreach ($incomingOptions as $optionData) {
                if (isset($optionData['id'])) {
                    // Opción existente - agregar a la lista de sincronización
                    $optionsToSync[] = $optionData['id'];
                } else {
                    // Nueva opción - crear y agregar a la lista de sincronización
                    $newOption = $question->options()->create([
                        'content' => $optionData['content']
                    ]);
                    $optionsToSync[] = $newOption->id;
                }
            }

            // Sincronizar todas las opciones (esto eliminará las que no estén en el array)
            $question->options()->sync($optionsToSync);

            return to_route('questions.index')->with('success', 'Pregunta actualizada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al actualizar la pregunta.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Question::destroy($id);
            return to_route('questions.index')->with('success', 'Pregunta eliminada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al eliminar la pregunta.');
        }
    }
}
