<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>katalog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex flex-col font-sans">

<!-- Navbar -->
<div class="bg-white shadow-sm px-6 py-4 flex justify-center gap-4">
    <a href="/" class="px-4 py-2 rounded-full hover:bg-slate-200">Home</a>
    <a href="/profil" class="px-4 py-2 rounded-full hover:bg-slate-200">Profil</a>
    <a href="/katalog" class="px-4 py-2 rounded-full bg-slate-900 text-white">Katalog</a>
    <a href="/bantuan" class="px-4 py-2 rounded-full hover:bg-slate-200">Bantuan</a>
    <a href="/contact" class="px-4 py-2 rounded-full hover:bg-slate-200 transition">Contact</a>

</div>

<div class="flex-grow px-6 py-10 max-w-5xl mx-auto">
    <h2 class="text-2xl font-semibold text-slate-800 mb-6">Katalog Event</h2>

    <div class="grid md:grid-cols-3 gap-5">

        <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
            <h3 class="font-semibold text-slate-800">Seminar IT</h3>
            <p class="text-slate-500 text-sm mt-1">Teknologi terbaru</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
            <h3 class="font-semibold text-slate-800">Workshop UI/UX</h3>
            <p class="text-slate-500 text-sm mt-1">Desain modern</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
            <h3 class="font-semibold text-slate-800">CodingRacing</h3>
            <p class="text-slate-500 text-sm mt-1">Kompetisi coding</p>
        </div>

    </div>
</div>

</body>