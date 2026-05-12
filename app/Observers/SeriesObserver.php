<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Series;
use Illuminate\Support\Facades\Auth;

class SeriesObserver
{
    public function created(Series $series): void
    {
        ActivityLog::create([
            'user_id'     => Auth::id() ?? $series->user_id,
            'series_id'   => $series->id,
            'action'      => ActivityLog::ACTION_ADDED,
            'description' => "Added \"{$series->title}\" to the Imperial Archives.",
            'metadata'    => [
                'title'  => $series->title,
                'type'   => $series->type,
                'status' => $series->status,
            ],
        ]);
    }

    public function updated(Series $series): void
    {
        $dirty = $series->getDirty();
        if (empty($dirty)) {
            return;
        }

        $changes = [];
        foreach ($dirty as $field => $newValue) {
            $old = $series->getOriginal($field);
            $changes[] = "Changed {$field} from '{$old}' to '{$newValue}'";
        }

        ActivityLog::create([
            'user_id'     => Auth::id() ?? $series->user_id,
            'series_id'   => $series->id,
            'action'      => ActivityLog::ACTION_EDITED,
            'description' => implode('. ', $changes) . '.',
            'metadata'    => ['changed_fields' => array_keys($dirty)],
        ]);
    }

        public function deleted(Series $series): void
    {
        ActivityLog::create([
            'user_id' => $series->user_id,
            'series_id' => null, // <-- CRITICAL: Must be null
            'action' => 'deleted',
            'description' => 'Removed "' . $series->title . '" from the Imperial Archives.',
            'metadata' => ['title' => $series->title],
        ]);
    }
}
