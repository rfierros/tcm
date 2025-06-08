<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Welcome</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid items-center grid-cols-2 gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <x-application-logo class="block w-auto h-16 text-gray-800 fill-current" />
                        </div>
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>

                    <main class="mt-6">
                        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                            <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                                <div class="relative flex items-center gap-6 lg:items-end">
                                    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />
                                        <h2 class="text-xl font-semibold leading-tight text-gray-800">
                                            {{ __('Clasificación') }}
                                        </h2>
                                    </div>

                                </div>
                            </div>

                            <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                                <div class="relative flex items-center gap-6 lg:items-end">
                                    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />
                                        <h2 class="text-xl font-semibold leading-tight text-gray-800">
                                            {{ __('Resultados última carrera') }}
                                        </h2>
                                    </div>

                                </div>
                            </div>


                            
                        </div>
                    </main>

                    <footer class="py-16 text-sm text-center text-black dark:text-white/70">
                        © 2025 Pawa, all rights reserved. Hecho con ❤️ para un TCM más fácil.
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
