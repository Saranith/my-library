@extends('layouts.app')
@section('title', 'Seal New Entry')

@section('back_button')
    <a href="{{ route('collection.index') }}" class="flex items-center justify-center w-10 h-10 active:scale-95 transition-transform">
        <span class="material-symbols-outlined text-primary">arrow_back</span>
    </a>
    <h1 class="font-newsreader text-headline-sm text-primary uppercase tracking-widest">The Archivist</h1>
@endsection

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">

    <section class="mb-10">
        <h2 class="font-newsreader text-headline-lg-mobile text-on-surface mb-2">Seal New Entry</h2>
        <p class="font-newsreader text-body-md text-on-surface-variant">Document the acquisition of a new sequential art manuscript for the Imperial Archives.</p>
    </section>

    <form action="{{ route('series.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf

        {{-- Cover Art --}}
        <div>
            <label class="font-inter text-label-md text-outline uppercase mb-3 block">Cover Art</label>
            <div class="relative group h-64 w-full bg-surface-container overflow-hidden border border-outline-variant deep-shadow flex items-center justify-center cursor-pointer" id="cover-drop-zone" onclick="document.getElementById('cover_input').click()">
                <img id="cover-preview" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-500 hidden" />
                <div class="relative z-10 flex flex-col items-center pointer-events-none" id="upload-placeholder">
                    <span class="material-symbols-outlined text-primary text-5xl mb-3" style="font-variation-settings:'FILL' 1;">add_a_photo</span>
                    <span class="font-inter text-label-md text-primary uppercase">Upload Cover Art</span>
                    <span class="font-newsreader text-body-md text-on-surface-variant mt-1 text-sm">or paste a URL below</span>
                </div>
                <input type="file" id="cover_input" name="cover_image" accept="image/*" class="hidden" onchange="previewCover(this)" />
            </div>
            <input
                type="url"
                name="cover_url"
                id="cover_url_input"
                placeholder="https://example.com/cover.jpg"
                value="{{ old('cover_url') }}"
                class="input-underlined font-newsreader text-body-md mt-3"
                oninput="previewUrl(this.value)"
            />
            @error('cover_image') <p class="font-inter text-label-md text-error mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Core Details --}}
        <div class="space-y-6">
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Manuscript Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Vagabond, Vol. 1" required class="input-underlined font-newsreader text-body-lg" />
                @error('title') <p class="font-inter text-label-md text-error mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Author</label>
                <input type="text" name="author" value="{{ old('author') }}" placeholder="e.g. Takehiko Inoue" class="input-underlined font-newsreader text-body-md" />
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Source Link</label>
                <div class="relative flex items-center">
                    <input type="url" name="source_link" value="{{ old('source_link') }}" placeholder="https://..." class="input-underlined font-newsreader text-body-md w-full pr-10" />
                    <span class="material-symbols-outlined absolute right-0 text-outline-variant">link</span>
                </div>
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Synopsis</label>
                <textarea name="synopsis" rows="4" placeholder="A brief description of the series..." class="input-underlined font-newsreader text-body-md resize-none">{{ old('synopsis') }}</textarea>
            </div>
        </div>

        {{-- Origin / Date / Type / Status --}}
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Format Origin *</label>
                <select name="format_origin" required class="input-underlined font-newsreader text-body-md appearance-none">
                    @foreach(['Digital Scan', 'Tankobon Physical', 'Serialization', "Collector's Edition"] as $fmt)
                        <option value="{{ $fmt }}" {{ old('format_origin') === $fmt ? 'selected' : '' }}>{{ $fmt }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Induction Date *</label>
                <input type="date" name="induction_date" value="{{ old('induction_date', now()->format('Y-m-d')) }}" required class="input-underlined font-newsreader text-body-md" />
                @error('induction_date') <p class="font-inter text-label-md text-error mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Type *</label>
                <select name="type" required class="input-underlined font-newsreader text-body-md appearance-none">
                    @foreach(['MANGA', 'MANHUA', 'MANHWA'] as $t)
                        <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="font-inter text-label-md text-outline uppercase mb-1 block">Status *</label>
                <select name="status" required class="input-underlined font-newsreader text-body-md appearance-none">
                    @foreach(['Plan to Read', 'Currently Reading', 'Completed', 'On Hold', 'Dropped'] as $s)
                        <option value="{{ $s }}" {{ old('status', 'Plan to Read') === $s ? 'selected' : '' }}>{{ $s }}</option>
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
                    <input type="number" name="chapters_completed" id="ch-completed" value="{{ old('chapters_completed', 0) }}" min="0" class="input-underlined font-newsreader text-body-md text-center" oninput="updateProgressBar()" />
                </div>
                <div class="text-outline-variant font-newsreader text-headline-md mt-4">/</div>
                <div class="flex-1 flex flex-col">
                    <span class="font-inter text-[10px] text-outline uppercase mb-1">Total Chapters</span>
                    <input type="number" name="chapters_total" id="ch-total" value="{{ old('chapters_total') }}" min="1" placeholder="—" class="input-underlined font-newsreader text-body-md text-center" oninput="updateProgressBar()" />
                </div>
            </div>
            <div class="mt-6 h-1 w-full bg-surface-variant">
                <div class="h-full bg-primary transition-all shadow-[0_0_10px_rgba(233,193,118,0.5)]" id="form-progress-bar" style="width: 0%;"></div>
            </div>
        </div>

        {{-- Rating --}}
        <div>
            <label class="font-inter text-label-md text-outline uppercase mb-1 block">Personal Rating (0–10)</label>
            <input type="number" name="rating" value="{{ old('rating') }}" min="0" max="10" step="0.1" placeholder="e.g. 9.4" class="input-underlined font-newsreader text-body-md" />
        </div>

        {{-- Tags --}}
        <div>
            <label class="font-inter text-label-md text-outline uppercase mb-3 block">Classifications</label>
            <div class="flex flex-wrap gap-2" id="tags-container">
                {{-- Existing tags from old() --}}
                @foreach(old('tags', []) as $tag)
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
                Seal into Archives
            </button>
            <a href="{{ route('collection.index') }}" class="block w-full py-5 border border-outline-variant text-outline font-inter text-[14px] uppercase tracking-[0.2em] active:scale-[0.98] transition-all text-center hover:border-on-surface-variant">
                Discard Draft
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewCover(input) {
    if (input.files && input.files[0]) {
        const url = URL.createObjectURL(input.files[0]);
        // Clear the URL field when a file is chosen
        document.getElementById('cover_url_input').value = '';
        showPreview(url);
    }
}

function previewUrl(url) {
    const img = document.getElementById('cover-preview');
    if (url && url.trim()) {
        // Only show preview once the image actually loads
        img.onload = function () {
            showPreview(url);
        };
        img.onerror = function () {
            img.classList.add('hidden');
            document.getElementById('upload-placeholder').classList.remove('hidden');
        };
        img.src = url;
    } else {
        img.classList.add('hidden');
        document.getElementById('upload-placeholder').classList.remove('hidden');
    }
}

function showPreview(url) {
    const img = document.getElementById('cover-preview');
    img.src = url;
    img.classList.remove('hidden');
    document.getElementById('upload-placeholder').classList.add('hidden');
}

// Auto-preview if cover_url is pre-filled (e.g. after validation error)
document.addEventListener('DOMContentLoaded', function () {
    const urlInput = document.getElementById('cover_url_input');
    if (urlInput && urlInput.value.trim()) {
        previewUrl(urlInput.value.trim());
    }
});
</script>
<x-series-form-scripts />
@endpush
@endsection
