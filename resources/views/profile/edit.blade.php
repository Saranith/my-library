@extends('layouts.app')
@section('title', 'Archivist Identity')

{{-- Overrides the header logo with a back button --}}
@section('back_button')
    <a href="{{ route('collection.index') }}" class="flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors group">
        <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
        <span class="font-inter text-label-md uppercase tracking-widest hidden sm:block">Return to Archives</span>
    </a>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 md:px-8 py-8 pb-24">
    
    <div class="mb-10">
        <h2 class="font-newsreader text-headline-lg text-on-background mb-2">Archivist Identity</h2>
        <p class="font-inter text-sm text-outline">Manage your credentials and access to the Imperial Library.</p>
    </div>

    <div class="space-y-8">
        
        {{-- Profile Information --}}
        <section class="bg-surface-container p-6 md:p-8 border border-outline-variant deep-shadow">
            <header class="mb-6">
                <h3 class="font-newsreader text-headline-sm text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-xl">badge</span>
                    Personal Details
                </h3>
                <p class="font-inter text-sm text-on-surface-variant mt-1">Update your archival designation and contact coordinates.</p>
            </header>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="font-inter text-label-md text-outline uppercase block mb-2">Designation (Name)</label>
                    <input id="name" name="name" type="text" class="input-underlined" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    @error('name')
                        <p class="mt-2 font-inter text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="font-inter text-label-md text-outline uppercase block mb-2">Contact Link (Email)</label>
                    <input id="email" name="email" type="email" class="input-underlined" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    @error('email')
                        <p class="mt-2 font-inter text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="bg-primary text-on-primary px-6 py-3 font-inter text-label-md uppercase tracking-widest hover:bg-primary-container active:scale-95 transition-all">
                        Update Identity
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p class="font-inter text-sm text-primary transition-opacity duration-500">Saved.</p>
                    @endif
                </div>
            </form>
        </section>

        {{-- Password Update --}}
        <section class="bg-surface-container p-6 md:p-8 border border-outline-variant deep-shadow">
            <header class="mb-6">
                <h3 class="font-newsreader text-headline-sm text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-xl">key</span>
                    Security Seal
                </h3>
                <p class="font-inter text-sm text-on-surface-variant mt-1">Ensure your account is using a long, random password to stay secure.</p>
            </header>

            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <div>
                    <label for="current_password" class="font-inter text-label-md text-outline uppercase block mb-2">Current Seal</label>
                    <input id="current_password" name="current_password" type="password" class="input-underlined" autocomplete="current-password" />
                    @error('current_password', 'updatePassword')
                        <p class="mt-2 font-inter text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="font-inter text-label-md text-outline uppercase block mb-2">New Seal</label>
                    <input id="password" name="password" type="password" class="input-underlined" autocomplete="new-password" />
                    @error('password', 'updatePassword')
                        <p class="mt-2 font-inter text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="font-inter text-label-md text-outline uppercase block mb-2">Confirm New Seal</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="input-underlined" autocomplete="new-password" />
                    @error('password_confirmation', 'updatePassword')
                        <p class="mt-2 font-inter text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="bg-surface-container-highest border border-outline-variant text-on-surface px-6 py-3 font-inter text-label-md uppercase tracking-widest hover:border-primary hover:text-primary active:scale-95 transition-all">
                        Forge New Seal
                    </button>
                    @if (session('status') === 'password-updated')
                        <p class="font-inter text-sm text-primary transition-opacity duration-500">Saved.</p>
                    @endif
                </div>
            </form>
        </section>

        {{-- Delete Account (Danger Zone) --}}
        <section class="bg-error-container/10 p-6 md:p-8 border border-error/30 deep-shadow">
            <header class="mb-6">
                <h3 class="font-newsreader text-headline-sm text-error flex items-center gap-2">
                    <span class="material-symbols-outlined text-xl">warning</span>
                    Abandon Post
                </h3>
                <p class="font-inter text-sm text-on-surface-variant mt-1">Once your account is deleted, all of its resources and data will be permanently purged.</p>
            </header>

            <button onclick="document.getElementById('delete-modal').classList.remove('hidden')" class="bg-error/10 border border-error text-error px-6 py-3 font-inter text-label-md uppercase tracking-widest hover:bg-error hover:text-on-error active:scale-95 transition-all">
                Delete Account
            </button>
        </section>

    </div>
</div>

{{-- Simple Delete Confirmation Modal --}}
<div id="delete-modal" class="fixed inset-0 z-[100] hidden bg-background/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-surface-container border border-error p-6 md:p-8 max-w-lg w-full deep-shadow">
        <h2 class="font-newsreader text-headline-sm text-on-surface mb-2">Are you sure you want to delete your account?</h2>
        <p class="font-inter text-sm text-on-surface-variant mb-6">This action is irreversible. Please enter your password to confirm you would like to permanently delete your account.</p>
        
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            
            <div class="mb-6">
                <input type="password" name="password" placeholder="Password" class="input-underlined focus:border-error" required />
                @error('password', 'userDeletion')
                    <p class="mt-2 font-inter text-xs text-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" onclick="document.getElementById('delete-modal').classList.add('hidden')" class="px-6 py-3 font-inter text-label-md text-outline uppercase tracking-widest hover:text-on-surface transition-colors">
                    Cancel
                </button>
                <button type="submit" class="bg-error text-on-error px-6 py-3 font-inter text-label-md uppercase tracking-widest hover:bg-error-container hover:text-on-error-container transition-colors">
                    Confirm Deletion
                </button>
            </div>
        </form>
    </div>
</div>

{{-- If there was a deletion error, keep the modal open --}}
@if($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('delete-modal').classList.remove('hidden');
        });
    </script>
@endif

@endsection
