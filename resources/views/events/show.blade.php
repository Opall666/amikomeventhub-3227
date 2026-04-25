@extends('layouts.app')

@section('content')
<h1>{{ $event->title }}</h1>
<p><strong>Kategori:</strong> {{ $event->category->name }}</p>
<p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</p>
<p><strong>Lokasi:</strong> {{ $event->location }}</p>
<p><strong>Harga:</strong> Rp {{ number_format($event->price, 0, ',', '.') }}</p>
<p><strong>Stok:</strong> {{ $event->stock }} tiket</p>
<p>{{ $event->description }}</p>
<a href="{{ route('events.index') }}">← Kembali</a>
@endsection