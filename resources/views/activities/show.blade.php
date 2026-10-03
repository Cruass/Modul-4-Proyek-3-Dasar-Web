@extends('layouts.app')

@section('content')
    <h1>{{ $activity->title }}</h1>
    
    <ul>
        <li><strong>Tanggal:</strong> {{ $activity->activity_date->format('d M Y') }}</li>
        <li><strong>Kategori:</strong> {{ $activity->category }}</li>
        <li><strong>Status:</strong> {{ $activity->status }}</li>
    </ul>
    
    <p><strong>Deskripsi:</strong><br>
       {{ $activity->description ?? 'Tidak ada deskripsi.' }}
    </p>

  <p><strong>Kategori:</strong> {{ $activity->category->name ?? '-' }}</p>

    <br>
    <a href="{{ route('activities.edit', $activity->id) }}">Edit Kegiatan</a> | 
    <a href="{{ route('activities.index') }}">← Kembali ke Daftar</a>
@endsection