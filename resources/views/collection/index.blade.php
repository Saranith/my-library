@extends('layouts.app')
@section('title', 'Collection')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 md:px-16 py-8 pb-24">

    {{-- Summary Stats Bento Grid --}}
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="col-span-2 md:col-span-1 bg-surface-container p-6 border border-outline-variant deep-shadow">
            <p class="font-inter text-label-md text-outline uppercase mb-2">Total Series</p>
            <div class="flex items-baseline gap-2">
                <span class="font-newsreader text-headline-lg text-primary">{{ $totalSeries }}</span>
                @if($newThisMonth > 0)
                    <span class="font-inter text-label-md text-tertiary">+{{ $newThisMonth }} this month</span>
                @endif
            </div>
        </div>
        <div class="bg-surface-container p-6 border border-outline-variant deep-shadow">
            <p class="font-inter text-label-md text-outline uppercase mb-2">Chapters</p>
            <span class="font-newsreader text-headline-md text-on-surface">
                {{ $totalChapters >= 1000 ? number_format($totalChapters / 1000, 1) . 'k' : $totalChapters }}
            </span>
        </div>
        <div class="bg-surface-container p-6 border border-outline-variant deep-shadow">
            <p class="font-inter text-label-md text-outline uppercase mb-2">Avg Rating</p>
            <div class="flex items-center gap-1">
                <span class="font-newsreader text-headline-md text-primary">{{ $avgRating }}</span>
                <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings:'FILL' 1;">star</span>
            </div>
        </div>
        <div class="hidden md:flex flex-col justify-center bg-primary p-6 border border-outline-variant deep-shadow">
            <p class="font-inter text-label-md text-on-primary uppercase mb-1">Status</p>
            <p class="font-newsreader text-headline-sm text-on-primary">{{ $librarianRank }}</p>
        </div>
    </section>

    {{-- Collection Grid --}}
    <section>
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 mb-6">
            <h2 class="font-newsreader text-headline-md text-on-surface">Current Readings</h2>
            <div class="flex gap-4 font-inter text-label-md">
                @foreach(['all' => 'ALL', 'MANGA' => 'MANGA', 'MANHUA' => 'MANHUA', 'MANHWA' => 'MANHWA'] as $val => $label)
                    <a href="{{ route('collection.index', array_merge(request()->query(), ['type' => $val])) }}"
                       class="{{ (($filter['type'] ?? 'all') === $val) ? 'text-primary border-b border-primary' : 'text-outline hover:text-on-surface transition-colors' }} cursor-pointer">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        @if($series->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <span class="material-symbols-outlined text-primary text-6xl mb-4 opacity-40">library_books</span>
                <p class="font-newsreader text-headline-sm text-on-surface-variant mb-2">The Archives Await</p>
                <p class="font-newsreader text-body-md text-outline mb-8">No manuscripts have been sealed into the Imperial Library yet.</p>
                <a href="{{ route('series.create') }}" class="bg-primary text-on-primary px-8 py-4 font-inter text-label-md uppercase tracking-widest hover:bg-primary-container transition-all">
                    Seal First Entry
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($series as $item)
                    <a href="{{ route('series.show', $item) }}" class="group flex flex-col gap-3">
                        <div class="relative aspect-[3/4] overflow-hidden border border-outline-variant deep-shadow transition-transform duration-300 group-hover:-translate-y-1">
                            @if($item->cover_image)
                                <img
                                    src="{{ str_starts_with($item->cover_image, 'http') ? $item->cover_image : asset('storage/'.$item->cover_image) }}"
                                    alt="{{ $item->title }}"
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500"
                                    referrerpolicy="no-referrer"
                                />
                            @else
                                <div class="w-full h-full bg-surface-container-high flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-5xl opacity-30" style="font-variation-settings:'FILL' 1;">book</span>
                                </div>
                            @endif
                            {{-- Rating badge --}}
                            @if($item->rating)
                                <div class="absolute top-2 right-2 bg-surface-container-highest/90 border border-primary px-2 py-1 flex items-center gap-1">
                                    <span class="font-inter text-[10px] text-primary">{{ $item->rating }}</span>
                                    <span class="material-symbols-outlined text-[10px] text-primary" style="font-variation-settings:'FILL' 1;">star</span>
                                </div>
                            @endif
                            {{-- Type badge --}}
                            <div class="absolute top-2 left-2 bg-surface-container-highest/90 px-2 py-1">
                                <span class="font-inter text-[9px] text-on-surface-variant uppercase">{{ $item->type }}</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-newsreader text-headline-sm text-on-surface leading-tight mb-1 truncate">{{ $item->title }}</h3>
                            <p class="font-inter text-label-md text-outline uppercase mb-2">{{ $item->formatted_chapters }}</p>
                            <div class="w-full h-[2px] bg-surface-variant">
                                <div class="h-full bg-primary transition-all" style="width: {{ $item->progress_percentage }}%;"></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($series->hasPages())
                <div class="mt-10 flex justify-center">
                    {{ $series->appends(request()->query())->links('pagination::simple-tailwind') }}
                </div>
            @endif
        @endif
    </section>
</div>

{{-- FAB --}}
<a href="{{ route('series.create') }}" class="fixed bottom-24 right-6 md:right-12 md:bottom-8 bg-primary text-on-primary w-14 h-14 flex items-center justify-center deep-shadow hover:scale-110 active:scale-95 transition-all duration-200 z-50">
    <span class="material-symbols-outlined text-3xl">add</span>
</a>
@endsection
