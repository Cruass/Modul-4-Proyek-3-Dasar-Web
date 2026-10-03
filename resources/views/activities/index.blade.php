@extends('layouts.app')

@section('content')
    <h1>Daftar Kegiatan</h1>

    <form method="GET" action="{{ route('activities.index') }}" style="margin-bottom: 20px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode/judul...">
        
        <select name="category_id">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="status">
            <option value="">Semua Status</option>
            <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
            <option value="Published" {{ request('status') == 'Published' ? 'selected' : '' }}>Published</option>
            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <select name="sort">
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Tanggal Terbaru</option>
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tanggal Terlama</option>
        </select>

        <button type="submit">Terapkan</button>
    </form>
    <br>
    
    @forelse ($activities as $activity)
        <article class="card" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 10px;">
            <h2 style="margin-top: 0;">
                <a href="{{ route('activities.show', $activity) }}">
                    {{ $activity->title }}
                </a>
            </h2>
            
            <p style="margin: 5px 0; color: #555;">
                <strong>Kategori:</strong> {{ $activity->category->name ?? 'Tanpa Kategori' }}
            </p>
            
            <p style="margin: 5px 0;">Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
            <p style="margin: 5px 0;">Status: <strong>{{ $activity->status }}</strong></p>

            <div style="margin-top: 10px;">
                @if($activity->status === 'Draft')
                    <form action="{{ route('activities.publish', $activity->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="background-color: green; color: white; padding: 5px 10px; border: none; cursor: pointer;">Publish</button>
                    </form>
                @endif

                @if($activity->status === 'Published')
                    <form action="{{ route('activities.complete', $activity->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="background-color: blue; color: white; padding: 5px 10px; border: none; cursor: pointer;">Complete</button>
                    </form>
                @endif

                <!-- Tombol Hapus (Soft Delete) -->
                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" style="display:inline; margin-left: 5px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background-color: red; color: white; padding: 5px 10px; border: none; cursor: pointer;" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                </form>
            </div>
        </article>
    @empty
        <p>Belum ada kegiatan.</p>
    @endforelse

    <div style="margin-top: 20px;">
        @if($activities->previousPageUrl())
            <a href="{{ $activities->previousPageUrl() }}" style="padding: 8px 15px; background-color: #ddd; color: black; text-decoration: none; border: 1px solid #999;">&laquo; Previous</a>
        @endif

        @if($activities->nextPageUrl())
            <a href="{{ $activities->nextPageUrl() }}" style="padding: 8px 15px; background-color: #ddd; color: black; text-decoration: none; border: 1px solid #999; margin-left: 10px;">Next &raquo;</a>
        @endif
    </div>

@endsection