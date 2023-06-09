<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>Jabu Task</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <wireui:scripts />

    @vite(['resources/js/app.js', 'resources/js/vendor/webauthn/webauthn.js'])

    @livewireStyles
</head>

<body>
    <div class="flex min-h-screen flex-row bg-blue-100 text-gray-800">
        <main class="main -ml-48 flex flex-grow flex-col py-3 transition-all duration-150 ease-in md:ml-0">
            {{$slot}}
        </main>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')

    @livewireScripts
</body>

</html>
