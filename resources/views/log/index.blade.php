@extends('layouts.app')
@section('title', 'Reading Log')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8 pb-24">

    {{-- Header + Search --}}
    <section class="mb-10">
        <h2 class="font-newsreader text-headline-lg text-on-background mb-6">Reading Log</h2>
        <form method="GET" action="{{ route('log.index') }}" class="relative group mb-4">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input
                name="search"
                value="{{ $search }}"
                type="text"
                placeholder="Search entries, edits, or titles..."
                class="w-full bg-surface-container-lowest border-b border-outline-variant py-4 pl-12 pr-4 focus:outline-none focus:border-primary transition-colors duration-300 text-on-surface placeholder:text-on-surface-variant/50 font-newsreader text-body-md"
            />
            <input type="hidden" name="filter" value="{{ $filter }}" />
        </form>

        {{-- Filter chips --}}
        <div class="flex gap-2 overflow-x-auto pb-2">
            @foreach(['all' => 'All Activity', 'added' => 'Added', 'edited' => 'Edited', 'deleted' => 'Deleted'] as $val => $label)
                <a href="{{ route('log.index', ['filter' => $val, 'search' => $search]) }}"
                   class="px-4 py-1.5 rounded-lg border font-inter text-label-md uppercase cursor-pointer whitespace-nowrap transition-colors
                          {{ $filter === $val ? 'border-primary bg-primary/10 text-primary' : 'border-outline-variant text-on-surface-variant hover:border-primary' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </section>

    {{-- Timeline --}}
    @if($logs->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <span class="material-symbols-outlined text-primary text-6xl mb-4 opacity-40">history_edu</span>
            <p class="font-newsreader text-headline-sm text-on-surface-variant mb-2">No Activity Yet</p>
            <p class="font-newsreader text-body-md text-outline">Your archival history will appear here once you begin cataloguing manuscripts.</p>
        </div>
    @else
        <div class="space-y-0">
            @foreach($logs as $log)
                <div class="timeline-item relative flex gap-6 pb-12 group">
                    <div class="timeline-line relative shrink-0">
                        <div class="w-6 h-6 bg-surface-container-highest border flex items-center justify-center z-10 relative {{ $log->action === 'deleted' ? 'border-error' : 'border-primary' }}">
                            <span class="material-symbols-outlined text-[14px] {{ $log->action === 'deleted' ? 'text-error' : 'text-primary' }}" style="font-variation-settings:'FILL' 1;">{{ $log->action_icon }}</span>
                        </div>
                    </div>
                    <div class="flex-1 bg-surface-container p-5 border border-outline-variant/30 shadow-[0_20px_40px_rgba(0,0,0,0.4)] hover:border-{{ $log->action === 'deleted' ? 'error/30' : 'primary/50' }} transition-all duration-300">
                        <div class="flex justify-between items-start mb-3">
                            <span class="font-inter text-label-md {{ $log->action === 'deleted' ? 'text-error' : 'text-primary' }} uppercase tracking-widest">
                                {{ $log->action_label }}
                            </span>
                            <span class="font-inter text-label-md text-on-surface-variant/60">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex gap-4">
                            {{-- Series cover thumbnail --}}
                            <div class="w-16 h-24 bg-surface-variant border border-outline-variant shrink-0 overflow-hidden shadow-lg {{ $log->action === 'deleted' ? 'opacity-40' : '' }}">
                                @if($log->series && $log->series->cover_image)
                                    <img
                                        src="{{ str_starts_with($log->series->cover_image, 'http') ? $log->series->cover_image : asset('storage/'.$log->series->cover_image) }}"
                                        alt="{{ $log->series->title ?? 'Series' }}"
                                        class="w-full h-full object-cover grayscale-[0.2] hover:grayscale-0 transition-all duration-500"
                                    />
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary opacity-30" style="font-variation-settings:'FILL' 1;">book</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                @if($log->series)
                                    <h3 class="font-newsreader text-headline-sm text-on-surface mb-1 {{ $log->action === 'deleted' ? 'line-through text-on-surface-variant' : '' }} truncate">
                                        @if($log->action !== 'deleted')
                                            <a href="{{ route('series.show', $log->series) }}" class="hover:text-primary transition-colors">{{ $log->series->title }}</a>
                                        @else
                                            {{ $log->series->title ?? ($log->metadata['title'] ?? 'Unknown') }}
                                        @endif
                                    </h3>
                                @else
                                    <h3 class="font-newsreader text-headline-sm text-on-surface-variant mb-1 line-through">
                                        {{ $log->metadata['title'] ?? 'Deleted Series' }}
                                    </h3>
                                @endif
                                <p class="text-on-surface-variant text-sm leading-relaxed line-clamp-3">{{ $log->description }}</p>

                                @if($log->series && !empty($log->series->tags))
                                    <div class="mt-3 flex flex-wrap items-center gap-2">
                                        @foreach(array_slice($log->series->tags, 0, 3) as $tag)
                                            <span class="px-2 py-0.5 bg-surface-container-highest border border-outline-variant font-inter text-[10px] text-on-surface-variant uppercase font-bold">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $logs->appends(request()->query())->links('pagination::simple-tailwind') }}
            </div>
        @endif
    @endif
</div>

{{-- FAB --}}
<a href="{{ route('series.create') }}" class="fixed bottom-24 right-6 md:right-8 md:bottom-8 bg-primary text-on-primary w-14 h-14 flex items-center justify-center shadow-[0_10px_30px_rgba(233,193,118,0.3)] hover:scale-105 active:scale-95 transition-all z-40">
    <span class="material-symbols-outlined">add</span>
</a>
@endsection
