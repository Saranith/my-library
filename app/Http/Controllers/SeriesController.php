<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Series::class);

        $series = Series::where('user_id', auth()->id())->get();

        return view('collection.index', compact('series'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Series::class);

        return view('series.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Series::class);

        // We added all the missing fields here so Laravel allows them through!
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'synopsis'           => 'nullable|string',
            'cover_image'        => 'nullable|string', // Changed to string so it doesn't fail strict URL checks
            'chapters_completed' => 'nullable|integer|min:0',
            'chapters_total'     => 'nullable|integer|min:0',
            'status'             => 'nullable|string',
            'type'               => 'nullable|string',
            'rating'             => 'nullable|numeric|min:0|max:10',
            'author'             => 'nullable|string|max:255',
            'source_link'        => 'nullable|string',
        ]);

        // Automatically set the induction date to right now
        $validated['induction_date'] = now();

        $request->user()->series()->create($validated);

        return redirect()->route('collection.index')->with('success', 'Series created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Series $series)
    {
        Gate::authorize('view', $series);

        return view('series.show', compact('series'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Series $series)
    {
        Gate::authorize('update', $series);

        return view('series.edit', compact('series'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Series $series)
    {
        Gate::authorize('update', $series);

        // Updated these validation rules to match the store method
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'synopsis'           => 'nullable|string',
            'cover_image'        => 'nullable|string',
            'chapters_completed' => 'nullable|integer|min:0',
            'chapters_total'     => 'nullable|integer|min:0',
            'status'             => 'nullable|string',
            'type'               => 'nullable|string',
            'rating'             => 'nullable|numeric|min:0|max:10',
            'author'             => 'nullable|string|max:255',
            'source_link'        => 'nullable|string',
        ]);

        $series->update($validated);

        return redirect()->route('series.show', $series)->with('success', 'Series updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Series $series)
    {
        Gate::authorize('delete', $series);

        $series->delete();

        return redirect()->route('collection.index')->with('success', 'Series deleted successfully.');
    }
}
