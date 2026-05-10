@extends('layouts.app')
@section('content')

    <!-- Hero Section (Tetap sama, tidak diubah) -->
    <section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 space-y-8">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                #1 Event Platform
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
            </p>
            <div class="flex gap-4">
                <a href="#events" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                    Mulai Jelajah
                </a>
                <a href="#" class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                    Cara Pesan
                </a>
            </div>
        </div>
        <div class="flex-1 relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <img src="{{ asset('assets/concert.png') }}" alt="Concert" class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">
            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Grid (DINAMIS - Sudah Dirapikan) -->
        <!-- Events Grid (DINAMIS - Load More) -->
    <section id="events" class="max-w-7xl mx-auto px-6 py-20">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
                <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
            </div>
            <div class="flex gap-2">
                <button class="p-3 border rounded-xl hover:bg-white hover:shadow-md transition">Semua Kategori</button>
            </div>
        </div>

        <!-- ✅ Container untuk Load More -->
        <div id="event-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @include('partials.event-card', ['events' => $events])
        </div>

        <!-- Tombol Load More -->
        <div class="text-center mt-12">
    <!-- Tombol Load More -->
            <button id="load-more-btn" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed" style="display: none;">
                Muat Lebih Banyak
            </button>
            
            <!-- Loading Text -->
            <p id="loading-text" class="text-slate-500 mt-2 hidden">Memuat event...</p>
            
            <!-- Pesan: Semua Event Sudah Ditampilkan (Hidden by default) -->
            <p id="end-message" class="text-slate-400 mt-4 hidden flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                </svg>
                ✨ Semua event sudah ditampilkan 
            </p>
        </div>
    </section>

       <!--  Data Pagination -->
    <div id="pagination-data" 
         data-next-page="{{ $events->nextPageUrl() }}" 
         style="display: none;">
    </div>

    <button id="back-to-top" 
            class="fixed bottom-6 right-6 p-3 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 hover:scale-110 transition-all duration-300 opacity-0 invisible translate-y-4 z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ============================
            // 1. LOAD MORE LOGIC
            // ============================
            const loadMoreBtn = document.getElementById('load-more-btn');
            const loadingText = document.getElementById('loading-text');
            const container = document.getElementById('event-container');
            const endMessage = document.getElementById('end-message');
            const paginationData = document.getElementById('pagination-data');
            
            let nextPageUrl = paginationData?.dataset.nextPage || null;

            if (nextPageUrl) {
                loadMoreBtn.style.display = 'inline-block';
            }

            loadMoreBtn.addEventListener('click', async function() {
                if (!nextPageUrl) return;

                loadMoreBtn.disabled = true;
                loadMoreBtn.textContent = 'Memuat...';
                loadingText.classList.remove('hidden');

                try {
                    const response = await fetch(nextPageUrl, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    });
                    const data = await response.json();

                    if (data.html) {
                        container.insertAdjacentHTML('beforeend', data.html);
                    }

                    nextPageUrl = data.next_page;

                    if (!nextPageUrl) {
                        loadMoreBtn.style.display = 'none';
                        endMessage.classList.remove('hidden'); // ✅ Tampilkan pesan selesai
                    } else {
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = 'Muat Lebih Banyak';
                    }
                } catch (error) {
                    console.error('Error loading more events:', error);
                    loadMoreBtn.textContent = 'Gagal memuat, coba lagi';
                    setTimeout(() => {
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = 'Muat Lebih Banyak';
                    }, 2000);
                } finally {
                    loadingText.classList.add('hidden');
                }
            });

            // ============================
            // 2. BACK TO TOP LOGIC
            // ============================
            const backToTopBtn = document.getElementById('back-to-top');
            const scrollThreshold = 300; // Muncul setelah scroll 300px

            window.addEventListener('scroll', () => {
                if (window.scrollY > scrollThreshold) {
                    // Tampilkan tombol
                    backToTopBtn.classList.remove('opacity-0', 'invisible', 'translate-y-4');
                    backToTopBtn.classList.add('opacity-100', 'visible', 'translate-y-0');
                } else {
                    // Sembunyikan tombol
                    backToTopBtn.classList.add('opacity-0', 'invisible', 'translate-y-4');
                    backToTopBtn.classList.remove('opacity-100', 'visible', 'translate-y-0');
                }
            });

            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>

@endsection