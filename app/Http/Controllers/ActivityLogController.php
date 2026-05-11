<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->input('filter', 'all');
        $search = $request->input('search');

        $logs = $request->user()
            ->activityLogs()
            ->with('series')
            ->when($filter !== 'all', fn($q) => $q->where('action', $filter))
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('series', fn($sq) => $sq->where('title', 'like', "%{$search}%"));
            }))
            ->latest()
            ->paginate(20);

        return view('log.index', compact('logs', 'filter', 'search'));
    }
}
