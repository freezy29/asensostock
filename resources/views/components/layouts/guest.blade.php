<!DOCTYPE html>
<html lang="en" data-theme="light" style="scroll-padding-top: 5rem; scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - AsensoStock' : 'AsensoStock' }}</title>
    <link rel="preconnect" href="<https://fonts.bunny.net>">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body class="min-h-screen flex flex-col bg-base-200 font-sans">

        <main class="flex-1 container mx-auto px-4 py-8">
            {{ $slot }}
        </main>

    </body>
</html>
