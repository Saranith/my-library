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
            ->select('activity_logs.*')
            ->leftJoin('series', 'activity_logs.series_id', '=', 'series.id')
            ->when($filter !== 'all', fn($q) => $q->where('activity_logs.action', $filter))
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('activity_logs.description', 'like', "%{$search}%")
                  ->orWhere('series.title', 'like', "%{$search}%");
            }))
            ->latest('activity_logs.created_at')
            ->paginate(20);

        return view('log.index', compact('logs', 'filter', 'search'));
    }
}
