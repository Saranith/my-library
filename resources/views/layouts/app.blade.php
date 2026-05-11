<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'The Archivist') — Imperial Library</title>

    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;0,6..72,600;0,6..72,700;1,6..72,400&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'on-secondary': '#303034',
                        'on-secondary-fixed-variant': '#47464b',
                        'on-primary-container': '#4e3700',
                        'on-error': '#690005',
                        'on-error-container': '#ffdad6',
                        'surface-container-low': '#1c1b1d',
                        'inverse-on-surface': '#313032',
                        'background': '#131315',
                        'primary': '#e9c176',
                        'on-surface-variant': '#d1c5b4',
                        'tertiary': '#b0c6f9',
                        'on-tertiary-fixed-variant': '#304671',
                        'secondary-fixed': '#e4e1e7',
                        'on-background': '#e5e1e4',
                        'tertiary-container': '#8fa5d6',
                        'surface-container-high': '#2a2a2c',
                        'on-primary-fixed': '#261900',
                        'surface-variant': '#353437',
                        'inverse-primary': '#775a19',
                        'surface-dim': '#131315',
                        'error': '#ffb4ab',
                        'primary-fixed': '#ffdea5',
                        'on-primary': '#412d00',
                        'surface-container-highest': '#353437',
                        'tertiary-fixed': '#d8e2ff',
                        'secondary-container': '#47464b',
                        'tertiary-fixed-dim': '#b0c6f9',
                        'inverse-surface': '#e5e1e4',
                        'outline': '#9a8f80',
                        'primary-container': '#c5a059',
                        'outline-variant': '#4e4639',
                        'surface': '#131315',
                        'surface-container': '#201f21',
                        'on-tertiary-fixed': '#001a41',
                        'secondary-fixed-dim': '#c8c5cb',
                        'on-surface': '#e5e1e4',
                        'primary-fixed-dim': '#e9c176',
                        'on-secondary-container': '#b6b4b9',
                        'on-tertiary': '#173059',
                        'error-container': '#93000a',
                        'surface-container-lowest': '#0e0e10',
                        'surface-bright': '#39393b',
                        'surface-tint': '#e9c176',
                        'secondary': '#c8c5cb',
                        'on-secondary-fixed': '#1b1b1f',
                        'on-tertiary-container': '#233a65',
                        'on-primary-fixed-variant': '#5d4201',
                    },
                    borderRadius: {
                        DEFAULT: '0.125rem',
                        lg: '0.25rem',
                        xl: '0.5rem',
                        full: '0.75rem',
                    },
                    spacing: {
                        'container-max': '1440px',
                        'margin-desktop': '64px',
                        'gutter': '24px',
                        'margin-mobile': '16px',
                    },
                    fontFamily: {
                        'newsreader': ['Newsreader', 'serif'],
                        'inter': ['Inter', 'sans-serif'],
                    },
                    fontSize: {
                        'headline-lg': ['40px', { lineHeight: '1.2', letterSpacing: '-0.02em', fontWeight: '600' }],
                        'headline-lg-mobile': ['32px', { lineHeight: '1.2', fontWeight: '600' }],
                        'headline-md': ['28px', { lineHeight: '1.3', fontWeight: '500' }],
                        'headline-sm': ['20px', { lineHeight: '1.4', fontWeight: '500' }],
                        'body-lg': ['18px', { lineHeight: '1.6', fontWeight: '400' }],
                        'body-md': ['16px', { lineHeight: '1.6', fontWeight: '400' }],
                        'label-md': ['12px', { lineHeight: '1', letterSpacing: '0.05em', fontWeight: '600' }],
                    },
                },
            },
        };
    </script>
    <style>
        body { background-color: #131315; min-height: 100dvh; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; display: inline-block; line-height: 1; vertical-align: middle; }
        .deep-shadow { box-shadow: 0 20px 40px rgba(0,0,0,0.6); }
        .input-underlined { background-color: #0e0e10; border: none; border-bottom: 1px solid #9a8f80; border-radius: 0; padding: 12px 0; transition: border-color 0.3s; color: #e5e1e4; width: 100%; }
        .input-underlined:focus { outline: none; box-shadow: none; border-bottom-color: #e9c176; }
        .input-underlined::placeholder { color: #47464b; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #0e0e10; }
        ::-webkit-scrollbar-thumb { background: #4e4639; }
        input[type="range"]::-webkit-slider-thumb { -webkit-appearance: none; height: 16px; width: 16px; background: #e9c176; cursor: pointer; border-radius: 0; }
        .timeline-line::before { content: ''; position: absolute; left: 11px; top: 24px; bottom: -24px; width: 1px; background-color: #4e4639; }
        .timeline-item:last-child .timeline-line::before { display: none; }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-background font-newsreader selection:bg-primary-container selection:text-on-primary-container">

{{-- Flash messages --}}
@if(session('success'))
    <div id="flash-msg" class="fixed top-4 right-4 z-[100] bg-surface-container border border-primary px-5 py-3 font-inter text-label-md text-primary uppercase tracking-widest shadow-[0_10px_30px_rgba(233,193,118,0.3)]">
        <span class="material-symbols-outlined text-sm mr-2">check_circle</span>{{ session('success') }}
    </div>
    <script>setTimeout(() => document.getElementById('flash-msg')?.remove(), 3500);</script>
@endif
@if(session('error'))
    <div id="flash-err" class="fixed top-4 right-4 z-[100] bg-surface-container border border-error px-5 py-3 font-inter text-label-md text-error uppercase tracking-widest">
        {{ session('error') }}
    </div>
    <script>setTimeout(() => document.getElementById('flash-err')?.remove(), 3500);</script>
@endif

@auth
{{-- Top Header --}}
<header class="w-full top-0 sticky z-50 bg-surface border-b border-outline-variant shadow-2xl md:pl-64">
    <div class="flex justify-between items-center h-16 px-4 md:px-8 max-w-full mx-auto">
        <div class="flex items-center gap-4">
            @hasSection('back_button')
                @yield('back_button')
            @else
                <a href="{{ route('collection.index') }}" class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">library_books</span>
                    <h1 class="font-newsreader text-headline-sm text-primary uppercase tracking-widest hidden sm:block">The Archivist</h1>
                </a>
            @endif
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden md:flex relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm">search</span>
                <form action="{{ route('collection.index') }}" method="GET">
                    <input name="search" value="{{ request('search') }}" placeholder="Search collection..." class="bg-surface-container-lowest border-b border-outline focus:border-primary transition-all duration-300 pl-9 pr-4 py-1 text-sm outline-none text-on-surface placeholder:text-on-surface-variant/50" />
                </form>
            </div>
            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center border border-outline-variant">
                <span class="material-symbols-outlined text-on-primary text-sm">person</span>
            </div>
        </div>
    </div>
</header>

{{-- Desktop Sidebar --}}
<aside class="hidden md:flex h-screen w-64 fixed left-0 top-0 bg-surface-container border-r border-outline-variant shadow-[20px_0_40px_rgba(0,0,0,0.6)] flex-col py-8 gap-y-6 z-40">
    <div class="px-6 mb-2">
        <div class="flex items-center gap-3 mb-1">
            <div class="w-10 h-10 bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-on-primary" style="font-variation-settings:'FILL' 1;">menu_book</span>
            </div>
            <div>
                <h2 class="font-newsreader text-headline-sm text-primary">Imperial Library</h2>
                <p class="font-inter text-[10px] text-outline uppercase tracking-[0.2em]">Custodian of Tales</p>
            </div>
        </div>
    </div>
    <nav class="flex flex-col gap-y-1">
        <a href="{{ route('collection.index') }}" class="flex items-center gap-4 py-3 pl-6 transition-all duration-200 {{ request()->routeIs('collection.*') ? 'text-primary font-bold border-l-2 border-primary bg-surface-bright/20' : 'text-on-surface-variant hover:bg-surface-bright hover:text-primary' }}">
            <span class="material-symbols-outlined" @if(request()->routeIs('collection.*')) style="font-variation-settings:'FILL' 1;" @endif>library_books</span>
            <span class="font-newsreader text-body-md">Collection</span>
        </a>
        <a href="{{ route('log.index') }}" class="flex items-center gap-4 py-3 pl-6 transition-all duration-200 {{ request()->routeIs('log.*') ? 'text-primary font-bold border-l-2 border-primary bg-surface-bright/20' : 'text-on-surface-variant hover:bg-surface-bright hover:text-primary' }}">
            <span class="material-symbols-outlined" @if(request()->routeIs('log.*')) style="font-variation-settings:'FILL' 1;" @endif>history_edu</span>
            <span class="font-newsreader text-body-md">Reading Log</span>
        </a>
        <a href="{{ route('series.create') }}" class="flex items-center gap-4 py-3 pl-6 transition-all duration-200 {{ request()->routeIs('series.create') ? 'text-primary font-bold border-l-2 border-primary bg-surface-bright/20' : 'text-on-surface-variant hover:bg-surface-bright hover:text-primary' }}">
            <span class="material-symbols-outlined" @if(request()->routeIs('series.create')) style="font-variation-settings:'FILL' 1;" @endif>add_circle</span>
            <span class="font-newsreader text-body-md">Add Entry</span>
        </a>
    </nav>
    <div class="mt-auto px-6 pt-6 border-t border-outline-variant/30 flex flex-col gap-y-1">
        <div class="flex items-center gap-4 py-2 text-on-surface-variant hover:text-primary transition-colors cursor-pointer">
            <span class="material-symbols-outlined">account_circle</span>
            <span class="font-newsreader text-body-md">{{ auth()->user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-4 py-2 text-on-surface-variant hover:text-error transition-colors w-full">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-newsreader text-body-md">Exit Archive</span>
            </button>
        </form>
    </div>
</aside>

{{-- Main content --}}
<main class="md:pl-64 min-h-screen pb-20 md:pb-0">
    @yield('content')
</main>

{{-- Mobile Bottom Navigation --}}
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-surface-container border-t border-outline-variant px-6 py-3 flex justify-around items-center z-50">
    <a href="{{ route('collection.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('collection.*') ? 'text-primary' : 'text-on-surface-variant' }}">
        <span class="material-symbols-outlined" @if(request()->routeIs('collection.*')) style="font-variation-settings:'FILL' 1;" @endif>library_books</span>
        <span class="font-inter text-[10px] uppercase tracking-tighter">Collection</span>
    </a>
    <a href="{{ route('log.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('log.*') ? 'text-primary' : 'text-on-surface-variant' }}">
        <span class="material-symbols-outlined" @if(request()->routeIs('log.*')) style="font-variation-settings:'FILL' 1;" @endif>history_edu</span>
        <span class="font-inter text-[10px] uppercase tracking-tighter">Log</span>
    </a>
    <a href="{{ route('series.create') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('series.create') ? 'text-primary' : 'text-on-surface-variant' }}">
        <span class="material-symbols-outlined">add_circle</span>
        <span class="font-inter text-[10px] uppercase tracking-tighter">Add</span>
    </a>
</nav>
@endauth

@guest
    @yield('content')
@endguest

@stack('scripts')
</body>
</html>
