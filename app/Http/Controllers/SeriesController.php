<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SeriesController extends Controller
{
    public function show(Request $request, Series $series): View
    {
        Gate::authorize('view', $series);

        return view('series.show', compact('series'));
    }

    public function create(): View
    {
        return view('series.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'synopsis' => 'nullable|string',
            'source_link' => 'nullable|url|max:500',
            'format_origin' => 'required|in:Digital Scan,Tankobon Physical,Serialization,Collector\'s Edition',
            'induction_date' => 'required|date',
            'chapters_completed' => 'required|integer|min:0',
            'chapters_total' => 'nullable|integer|min:1',
            'rating' => 'nullable|numeric|min:0|max:10',
            'status' => 'required|in:Plan to Read,Currently Reading,Completed,On Hold,Dropped',
            'type' => 'required|in:MANGA,MANHUA,MANHWA',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'cover_image' => 'nullable|image|max:5120',
            'cover_url' => 'nullable|url|max:500',
            'official_sources' => 'nullable|array',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        } elseif ($request->filled('cover_url')) {
            $validated['cover_image'] = $request->input('cover_url');
        }

        $validated['user_id'] = $request->user()->id;
        $validated['tags'] = $request->input('tags', []);
        $validated['official_sources'] = $request->input('official_sources', []);

        $series = Series::create($validated);

        return redirect()->route('series.show', $series)
            ->with('success', "\"{$series->title}\" has been sealed into the Archives.");
    }

    public function edit(Series $series): View
    {
        Gate::authorize('update', $series);

        return view('series.edit', compact('series'));
    }

    public function update(Request $request, Series $series): RedirectResponse
    {
        Gate::authorize('update', $series);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'synopsis' => 'nullable|string',
            'source_link' => 'nullable|url|max:500',
            'format_origin' => 'required|in:Digital Scan,Tankobon Physical,Serialization,Collector\'s Edition',
            'induction_date' => 'required|date',
            'chapters_completed' => 'required|integer|min:0',
            'chapters_total' => 'nullable|integer|min:1',
            'rating' => 'nullable|numeric|min:0|max:10',
            'status' => 'required|in:Plan to Read,Currently Reading,Completed,On Hold,Dropped',
            'type' => 'required|in:MANGA,MANHUA,MANHWA',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'cover_image' => 'nullable|image|max:5120',
            'cover_url' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($series->cover_image && ! str_starts_with($series->cover_image, 'http')) {
                Storage::disk('public')->delete($series->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        } elseif ($request->filled('cover_url')) {
            $validated['cover_image'] = $request->input('cover_url');
        }

        $validated['tags'] = $request->input('tags', []);

        $series->update($validated);

        return redirect()->route('series.show', $series)
            ->with('success', "\"{$series->title}\" has been updated in the Archives.");
    }

    public function updateProgress(Request $request, Series $series): RedirectResponse
    {
        Gate::authorize('update', $series);

        $validated = $request->validate([
            'chapters_completed' => 'required|integer|min:0',
        ]);

        $series->update($validated);

        return back()->with('success', 'Reading progress updated.');
    }

    public function destroy(Series $series): RedirectResponse
    {
        Gate::authorize('delete', $series);
        $title = $series->title;

        if ($series->cover_image && ! str_starts_with($series->cover_image, 'http')) {
            Storage::disk('public')->delete($series->cover_image);
        }

        $series->delete();

        return redirect()->route('collection.index')
            ->with('success', "\"{$title}\" has been removed from the Archives.");
    }
}
