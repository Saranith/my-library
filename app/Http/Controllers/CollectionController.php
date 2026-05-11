<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $filter = $request->only(['search', 'type', 'status']);

        $series = $user->series()
            ->filter($filter)
            ->latest()
            ->paginate(20);

        // Stats
        $stats = $user->series()
            ->toBase()
            ->selectRaw('COUNT(*) as total_series')
            ->selectRaw('SUM(CASE WHEN created_at >= ? AND created_at <= ? THEN 1 ELSE 0 END) as new_this_month', [now()->startOfMonth(), now()->endOfMonth()])
            ->first();

        $totalSeries = (int) $stats->total_series;
        $newThisMonth = (int) $stats->new_this_month;
        $totalChapters = $user->total_chapters;
        $avgRating = $user->average_rating;
        $librarianRank = $user->librarian_rank;

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
