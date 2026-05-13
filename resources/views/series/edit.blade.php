@extends('layouts.app')
@section('title', 'Edit — ' . $series->title)

@section('back_button')
    <a href="{{ route('series.show', $series) }}" class="flex items-center justify-center w-10 h-10 active:scale-95 transition-transform">
        <span class="material-symbols-outlined text-primary">arrow_back</span>
    </a>
    <h1 class="font-newsreader text-headline-sm text-primary uppercase tracking-widest">The Archivist</h1>
@endsection

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">

    <section class="mb-10">
        <h2 class="font-newsreader text-headline-lg-mobile text-on-surface mb-2">Amend Record</h2>
        <p class="font-newsreader text-body-md text-on-surface-variant italic">Updating the archival record for "{{ $series->title }}".</p>
    </section>

    <form action="{{ route('series.update', $series) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf @method('PUT')

        {{-- Cover Art --}}
        <div>
            <label class="font-inter text-label-md text-outline uppercase mb-3 block">Cover Art</label>
            <div class="relative group h-64 w-full bg-surface-container overflow-hidden border border-outline-variant deep-shadow flex items-center justify-center cursor-pointer" onclick="document.getElementById('cover_input').click()">
                @if($series->cover_image)
                    <img id="cover-preview"
                         src="{{ str_starts_with($series->cover_image, 'http') ? $series->cover_image : asset('storage/'.$series->cover_image) }}"
                         class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-500"
                    />
                @else
                    <img id="cover-preview" class="absolute inset-0 w-full h-full object-cover opacity-80 hidden" />
                @endif
                <div class="relative z-10 flex flex-col items-center opacity-0 group-hover:opacity-100 transition-opacity" id="upload-placeholder">
                    <span class="material-symbols-outlined text-primary text-4xl" style="font-variation-settings:'FILL' 1;">photo_camera</span>
                    <span class="font-inter text-label-md text-primary uppercase mt-1">Change Cover</span>
                </div>
                <input type="file" id="cover_input" name="cover_image" accept="image/*" class="hidden" onchange="previewCover(this)" />
            </div>
            {{--
                Pre-fill with the existing URL if the stored cover_image is an external URL.
                This ensures: (a) the user sees what URL is currently saved, and
                (b) if they submit without changing anything, the controller keeps the URL.
            --}}
            <input
                type="url"
                name="cover_url"
                id="cover_url_input"
                placeholder="Or paste new URL..."
                value="{{ old('cover_url', str_starts_with($series->cover_image ?? '', 'http') ? $series->cover_image : '') }}"
                class="input-underlined font-newsreader text-body-md mt-3"
                oninput="previewUrl(this.value)"
            />
        </div>

        {{-- Core Details --}}
        <div class="space-y-6">
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Manuscript Title *</label>
                <input type="text" name="title" value="{{ old('title', $series->title) }}" required class="input-underlined font-newsreader text-body-lg" />
                @error('title') <p class="font-inter text-label-md text-error mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Author</label>
                <input type="text" name="author" value="{{ old('author', $series->author) }}" class="input-underlined font-newsreader text-body-md" />
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Source Link</label>
                <div class="relative flex items-center">
                    <input type="url" name="source_link" value="{{ old('source_link', $series->source_link) }}" class="input-underlined font-newsreader text-body-md w-full pr-10" />
                    <span class="material-symbols-outlined absolute right-0 text-outline-variant">link</span>
                </div>
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Synopsis</label>
                <textarea name="synopsis" rows="4" class="input-underlined font-newsreader text-body-md resize-none">{{ old('synopsis', $series->synopsis) }}</textarea>
            </div>
        </div>

        {{-- Origin / Date / Type / Status --}}
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Format Origin *</label>
                <select name="format_origin" required class="input-underlined font-newsreader text-body-md appearance-none">
                    @foreach(['Digital Scan', 'Tankobon Physical', 'Serialization', "Collector's Edition"] as $fmt)
                        <option value="{{ $fmt }}" {{ old('format_origin', $series->format_origin) === $fmt ? 'selected' : '' }}>{{ $fmt }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Induction Date *</label>
                <input type="date" name="induction_date" value="{{ old('induction_date', $series->induction_date?->format('Y-m-d')) }}" required class="input-underlined font-newsreader text-body-md" />
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Type *</label>
                <select name="type" required class="input-underlined font-newsreader text-body-md appearance-none">
                    @foreach(['MANGA', 'MANHUA', 'MANHWA'] as $t)
                        <option value="{{ $t }}" {{ old('type', $series->type) === $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Status *</label>
                <select name="status" required class="input-underlined font-newsreader text-body-md appearance-none">
                    @foreach(['Plan to Read', 'Currently Reading', 'Completed', 'On Hold', 'Dropped'] as $s)
                        <option value="{{ $s }}" {{ old('status', $series->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Chapter Progress --}}
        <div class="bg-surface-container p-6 border border-outline-variant deep-shadow">
            <label class="font-inter text-label-md text-outline uppercase mb-4 block">Chapter Progress</label>
            <div class="flex items-center gap-4">
                <div class="flex-1 flex flex-col">
                    <span class="font-inter text-[10px] text-outline uppercase mb-1">Completed</span>
                    <input type="number" name="chapters_completed" id="ch-completed" value="{{ old('chapters_completed', $series->chapters_completed) }}" min="0" class="input-underlined font-newsreader text-body-md text-center" oninput="updateProgressBar()" />
                </div>
                <div class="text-outline-variant font-newsreader text-headline-md mt-4">/</div>
                <div class="flex-1 flex flex-col">
                    <span class="font-inter text-[10px] text-outline uppercase mb-1">Total Chapters</span>
                    <input type="number" name="chapters_total" id="ch-total" value="{{ old('chapters_total', $series->chapters_total) }}" min="1" placeholder="—" class="input-underlined font-newsreader text-body-md text-center" oninput="updateProgressBar()" />
                </div>
            </div>
            <div class="mt-6 h-1 w-full bg-surface-variant">
                <div class="h-full bg-primary transition-all" id="form-progress-bar" style="width: {{ $series->progress_percentage }}%;"></div>
            </div>
        </div>

        {{-- Rating --}}
        <div>
            <label class="font-inter text-label-md text-outline uppercase mb-1 block">Personal Rating (0–10)</label>
            <input type="number" name="rating" value="{{ old('rating', $series->rating) }}" min="0" max="10" step="0.1" class="input-underlined font-newsreader text-body-md" />
        </div>

        {{-- Tags --}}
        <div>
            <label class="font-inter text-label-md text-outline uppercase mb-3 block">Classifications</label>
            <div class="flex flex-wrap gap-2" id="tags-container">
                @foreach(old('tags', $series->tags ?? []) as $tag)
                    <span class="tag-chip px-4 py-2 bg-surface-variant border border-outline-variant text-on-surface font-inter text-label-md flex items-center gap-2">
                        {{ $tag }}
                        <span class="material-symbols-outlined text-sm cursor-pointer" onclick="removeTag(this)">close</span>
                        <input type="hidden" name="tags[]" value="{{ $tag }}" />
                    </span>
                @endforeach
                <div class="flex gap-2">
                    <input type="text" id="tag-input" placeholder="Add tag..." class="input-underlined font-inter text-label-md w-32" onkeydown="handleTagKey(event)" />
                    <button type="button" onclick="addTag()" class="px-3 py-1 border border-dashed border-outline-variant text-primary font-inter text-label-md flex items-center gap-1 hover:border-primary transition-colors">
                        <span class="material-symbols-outlined text-sm">add</span> ADD
                    </button>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="pt-4 space-y-4">
            <button type="submit" class="w-full py-5 bg-primary text-on-primary font-inter text-[14px] uppercase tracking-[0.2em] shadow-[0_10px_25px_rgba(233,193,118,0.3)] active:scale-[0.98] transition-all">
                Update Record
            </button>
            <a href="{{ route('series.show', $series) }}" class="block w-full py-5 border border-outline-variant text-outline font-inter text-[14px] uppercase tracking-[0.2em] text-center hover:border-on-surface-variant transition-all">
                Cancel Changes
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Stored cover info for reverting when URL field is cleared
const storedCoverIsFile = {{ $series->cover_image && !str_starts_with($series->cover_image, 'http') ? 'true' : 'false' }};
const storedCoverSrc = '{{ $series->cover_image ? (str_starts_with($series->cover_image, 'http') ? $series->cover_image : asset("storage/" . $series->cover_image)) : "" }}';

function previewCover(input) {
    if (input.files && input.files[0]) {
        const url = URL.createObjectURL(input.files[0]);
        // Clear the URL field when a file is selected
        document.getElementById('cover_url_input').value = '';
        showPreview(url);
    }
}

function previewUrl(url) {
    const img = document.getElementById('cover-preview');
    if (url && url.trim()) {
        img.onload = function () {
            showPreview(url);
        };
        img.onerror = function () {
            // Bad URL — revert to stored cover if there is one
            if (storedCoverSrc) {
                img.src = storedCoverSrc;
                img.classList.remove('hidden');
            } else {
                img.classList.add('hidden');
            }
        };
        img.src = url;
    } else {
        // URL cleared — revert to stored cover or hide
        if (storedCoverSrc) {
            img.src = storedCoverSrc;
            img.classList.remove('hidden');
        } else {
            img.classList.add('hidden');
        }
    }
}

function showPreview(url) {
    const img = document.getElementById('cover-preview');
    img.src = url;
    img.classList.remove('hidden');
}
</script>
<x-series-form-scripts />
@endpush
@endsection
