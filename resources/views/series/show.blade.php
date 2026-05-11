@extends('layouts.app')
@section('title', $series->title)

@section('back_button')
    <a href="{{ route('collection.index') }}" class="flex items-center justify-center w-10 h-10 active:scale-95 transition-transform">
        <span class="material-symbols-outlined text-primary">arrow_back_ios_new</span>
    </a>
    <h1 class="font-newsreader text-headline-sm text-primary tracking-widest uppercase">The Archivist</h1>
@endsection

@section('content')
<div class="max-w-2xl mx-auto pb-16">

    {{-- Hero Cover --}}
    <section class="relative w-full aspect-[2/3] max-h-[520px] overflow-hidden">
        @if($series->cover_image)
            <img
                src="{{ str_starts_with($series->cover_image, 'http') ? $series->cover_image : asset('storage/'.$series->cover_image) }}"
                alt="{{ $series->title }}"
                class="w-full h-full object-cover"
            />
        @else
            <div class="w-full h-full bg-surface-container flex items-center justify-center">
                <span class="material-symbols-outlined text-primary opacity-20" style="font-size: 120px; font-variation-settings:'FILL' 1;">book</span>
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent"></div>
        @if($series->rating)
            <div class="absolute bottom-6 right-6 flex items-center gap-1 bg-surface-container-highest/90 border border-primary/30 px-3 py-1.5 rounded-lg">
                <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1;">star</span>
                <span class="font-inter text-label-md text-primary">{{ $series->rating }}</span>
            </div>
        @endif
    </section>

    {{-- Series Identity --}}
    <section class="px-4 -mt-16 relative z-10">
        <h2 class="font-newsreader text-headline-lg-mobile text-on-surface leading-tight">{{ $series->title }}</h2>
        @if($series->author)
            <p class="font-newsreader text-body-md text-primary mt-1 italic">{{ $series->author }}</p>
        @endif
        <div class="flex flex-wrap gap-2 mt-4">
            <span class="bg-surface-container-high border border-outline-variant px-3 py-1 font-inter text-label-md text-on-surface-variant uppercase tracking-wider">{{ $series->type }}</span>
            <span class="bg-surface-container-high border border-outline-variant px-3 py-1 font-inter text-label-md text-on-surface-variant uppercase tracking-wider">{{ $series->status }}</span>
            @if($series->chapters_total)
                <span class="bg-surface-container-high border border-outline-variant px-3 py-1 font-inter text-label-md text-on-surface-variant uppercase tracking-wider">{{ $series->chapters_total }} Chapters</span>
            @endif
            @foreach($series->tags ?? [] as $tag)
                <span class="bg-surface-container-high border border-outline-variant px-3 py-1 font-inter text-label-md text-on-surface-variant uppercase tracking-wider">{{ $tag }}</span>
            @endforeach
        </div>
    </section>

    {{-- Reading Progress --}}
    <section class="mt-8 px-4">
        <div class="bg-surface-container p-6 border border-outline-variant deep-shadow">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-inter text-label-md text-primary uppercase tracking-widest">Reading Progress</h3>
                <span class="font-newsreader text-body-md text-on-surface">
                    Chapter <span class="text-primary font-bold">{{ $series->chapters_completed }}</span>
                    @if($series->chapters_total) of {{ $series->chapters_total }} @endif
                </span>
            </div>
            <form action="{{ route('series.progress', $series) }}" method="POST">
                @csrf @method('PATCH')
                <div class="relative w-full h-2 bg-surface-variant mb-2">
                    <div class="absolute left-0 top-0 h-full bg-primary transition-all" id="progress-bar" style="width: {{ $series->progress_percentage }}%;"></div>
                    <input
                        type="range"
                        name="chapters_completed"
                        id="progress-range"
                        min="0"
                        max="{{ $series->chapters_total ?? 999 }}"
                        value="{{ $series->chapters_completed }}"
                        class="absolute inset-0 w-full opacity-0 cursor-pointer"
                        oninput="updateProgress(this.value)"
                    />
                </div>
                <div class="flex justify-between mt-2">
                    <span class="font-inter text-label-md text-on-surface-variant" id="progress-label">{{ $series->progress_percentage }}% Complete</span>
                    <button type="submit" class="font-inter text-label-md text-primary flex items-center gap-1 active:scale-95 transition-transform">
                        UPDATE <span class="material-symbols-outlined text-[14px]">edit</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- Actions --}}
    <section class="mt-6 px-4 flex gap-3">
        @if($series->source_link)
            <a href="{{ $series->source_link }}" target="_blank" rel="noopener" class="flex-1 bg-primary text-on-primary font-newsreader text-headline-sm py-4 flex items-center justify-center gap-3 active:scale-[0.98] transition-all">
                CONTINUE READING
                <span class="material-symbols-outlined">menu_book</span>
            </a>
        @endif
        <a href="{{ route('series.edit', $series) }}" class="flex items-center justify-center w-14 h-14 border border-outline-variant text-on-surface-variant hover:text-primary hover:border-primary transition-all">
            <span class="material-symbols-outlined">edit</span>
        </a>
        <form action="{{ route('series.destroy', $series) }}" method="POST" onsubmit="return confirm('Remove this manuscript from the Archives?')">
            @csrf @method('DELETE')
            <button type="submit" class="flex items-center justify-center w-14 h-14 border border-outline-variant text-on-surface-variant hover:text-error hover:border-error transition-all">
                <span class="material-symbols-outlined">delete_outline</span>
            </button>
        </form>
    </section>

    {{-- Synopsis --}}
    @if($series->synopsis)
        <section class="mt-10 px-4">
            <h3 class="font-newsreader text-headline-sm text-primary border-b border-outline-variant pb-2 mb-4">Synopsis</h3>
            <p class="font-newsreader text-body-md text-on-surface-variant leading-relaxed">{{ $series->synopsis }}</p>
        </section>
    @endif

    {{-- Official Sources --}}
    @php $sources = $series->official_sources ?? []; @endphp
    @if($series->source_link || count($sources))
        <section class="mt-10 px-4">
            <h3 class="font-newsreader text-headline-sm text-primary mb-4">Official Sources</h3>
            <div class="space-y-3">
                @if($series->source_link)
                    <a href="{{ $series->source_link }}" target="_blank" rel="noopener" class="flex items-center justify-between p-4 bg-surface-container-low border border-outline-variant active:bg-surface-variant transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">auto_stories</span>
                            <span class="font-newsreader text-body-md">Primary Source</span>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant">open_in_new</span>
                    </a>
                @endif
                @foreach($sources as $source)
                    <a href="{{ $source['url'] ?? '#' }}" target="_blank" rel="noopener" class="flex items-center justify-between p-4 bg-surface-container-low border border-outline-variant active:bg-surface-variant transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">public</span>
                            <span class="font-newsreader text-body-md">{{ $source['name'] ?? 'External Source' }}</span>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant">open_in_new</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Metadata footer --}}
    <section class="mt-10 px-4 pt-6 border-t border-outline-variant">
        <dl class="grid grid-cols-2 gap-4">
            <div>
                <dt class="font-inter text-label-md text-outline uppercase mb-1">Format</dt>
                <dd class="font-newsreader text-body-md text-on-surface-variant">{{ $series->format_origin }}</dd>
            </div>
            <div>
                <dt class="font-inter text-label-md text-outline uppercase mb-1">Inducted</dt>
                <dd class="font-newsreader text-body-md text-on-surface-variant">{{ $series->induction_date?->format('d M Y') }}</dd>
            </div>
        </dl>
    </section>
</div>

@push('scripts')
<script>
function updateProgress(val) {
    const total = {{ $series->chapters_total ?? 0 }};
    const pct = total > 0 ? Math.round((val / total) * 100) : 0;
    document.getElementById('progress-bar').style.width = pct + '%';
    document.getElementById('progress-label').textContent = pct + '% Complete';
}
</script>
@endpush
@endsection
