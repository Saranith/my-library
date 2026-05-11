<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(Request $request): View
    {
        $user   = $request->user();
        $filter = $request->only(['search', 'type', 'status']);

        $series = $user->series()
            ->filter($filter)
            ->latest()
            ->paginate(20);

        // Stats
        $totalSeries      = $user->series()->count();
        $newThisMonth     = $user->series()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $totalChapters    = $user->total_chapters;
        $avgRating        = $user->average_rating;
        $librarianRank    = $user->librarian_rank;

        return view('collection.index', compact(
            'series',
            'totalSeries',
            'newThisMonth',
            'totalChapters',
            'avgRating',
            'librarianRank',
            'filter'
        ));
    }
}
