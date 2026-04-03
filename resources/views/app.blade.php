<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bio-energy frequency therapy for a better life. Developed over 25 years of clinical practice by Dr. Éric Rosati.">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @inertiaHead
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#03142A] text-white">
    @inertia
</body>
</html>
