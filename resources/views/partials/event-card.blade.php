@forelse($events as $event)
<div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
    <div class="relative overflow-hidden aspect-[3/4]">
        @if($event->poster_path)
            <img src="{{ 
                    str_starts_with($event->poster_path, 'assets/') 
                        ? asset($event->poster_path)  
                        : asset('storage/' . $event->poster_path) 
                    }}"

                    alt="{{ $event->title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            @else
                {{-- Tampil kosong background abu-abu --}}
                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            @endif
            alt="{{ $event->title }}"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
            {{ $event->category->name }}
        </div>
    </div>
    <div class="p-6">
        <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">
            {{ Str::limit($event->title, 40) }}
        </h3>
        <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
        </div>
        <div class="flex justify-between items-center pt-4 border-t">
            <span class="text-2xl font-black text-indigo-600">
                @if($event->price == 0) Gratis @else Rp {{ number_format($event->price/1000, 0, ',', '.') }}rb @endif
            </span>
            <a href="{{ route('events.show', $event->id) }}" 
               class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">
                Lihat Detail
            </a>
        </div>
    </div>
</div>
@empty
<div class="col-span-full text-center py-12">
    <p class="text-slate-500 text-lg">Belum ada event yang tersedia.</p>
</div>
@endforelse