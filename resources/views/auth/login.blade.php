@extends('layouts.app')
@section('title', 'Enter Archive')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-4 bg-surface-container-lowest">
    <div class="w-full max-w-sm flex flex-col items-center">

        {{-- Brand Mark --}}
        <div class="mb-12 flex flex-col items-center text-center">
            <div class="w-24 h-24 mb-6 flex items-center justify-center bg-surface-container deep-shadow border border-outline-variant">
                <span class="material-symbols-outlined text-primary text-5xl" style="font-variation-settings:'FILL' 1;">auto_stories</span>
            </div>
            <h1 class="font-newsreader text-headline-md text-primary uppercase tracking-widest mb-1">Imperial Library</h1>
            <p class="font-newsreader text-body-md text-on-surface-variant italic">Custodian of Tales</p>
        </div>

        {{-- Login Form --}}
        <div class="w-full bg-surface-container p-8 deep-shadow border border-outline-variant">
            <form method="POST" action="{{ route('login.post') }}" class="flex flex-col gap-y-8">
                @csrf

                {{-- Username --}}
                <div class="flex flex-col gap-y-2">
                    <label for="username" class="font-inter text-label-md text-on-surface-variant uppercase">Archivist ID</label>
                    <input
                        id="username" name="username" type="text"
                        value="{{ old('username') }}"
                        placeholder="Username or Email"
                        required autofocus
                        class="input-underlined font-newsreader text-body-md"
                    />
                    @error('username')
                        <p class="font-inter text-label-md text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="flex flex-col gap-y-2">
                    <label for="password" class="font-inter text-label-md text-on-surface-variant uppercase">Password</label>
                    <input
                        id="password" name="password" type="password"
                        placeholder="••••••••"
                        required
                        class="input-underlined font-newsreader text-body-md"
                    />
                    @error('password')
                        <p class="font-inter text-label-md text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full bg-primary text-on-primary py-4 font-inter text-label-md uppercase tracking-widest hover:bg-primary-container active:scale-[0.98] transition-all duration-200">
                    Enter Archive
                </button>
            </form>

            <div class="mt-8 flex justify-center">
                <a href="#" class="font-inter text-label-md text-primary border-b border-transparent hover:border-primary transition-all duration-300">
                    Request Credentials
                </a>
            </div>
        </div>

        {{-- Decorative footer --}}
        <div class="mt-12 opacity-30">
            <span class="material-symbols-outlined text-primary text-4xl" style="font-variation-settings:'FILL' 1;">book_4_spark</span>
        </div>
    </div>

    <footer class="mt-auto py-8 text-center">
        <p class="font-inter text-label-md text-on-secondary-fixed-variant tracking-widest">THE ARCHIVIST SYSTEM V1.0</p>
    </footer>
</div>
@endsection
