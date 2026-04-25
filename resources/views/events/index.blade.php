@extends('layouts.app')

@section('content')
<h1>Daftar Event</h1>
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
    @foreach($events as $event)
        <div style="border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
            <h3>{{ $event->title }}</h3>
            <p>Kategori: {{ $event->category->name }}</p>
            <p>Harga: Rp {{ number_format($event->price, 0, ',', '.') }}</p>
            <a href="{{ route('events.show', $event->id) }}">Lihat Detail</a>
        </div>
    @endforeach
</div>
@endsection