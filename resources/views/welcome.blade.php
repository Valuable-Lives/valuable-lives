<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>{{ config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col items-center justify-center px-6">
            <div class="max-w-lg text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Valuable Lives</h1>
                <p class="text-gray-500 mb-8">Development preview</p>

                <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 mb-8 text-left">
                    <p class="text-sm text-amber-800">
                        This is a development site for the Valuable Lives project at the Centre for the Study of the Legacies of British Slavery, University College London.
                        All data shown is fictional and for testing purposes only. The site is not yet open to the public.
                    </p>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </body>
</html>
