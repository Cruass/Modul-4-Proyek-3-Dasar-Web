<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kegiatan</title>
</head>
<body>
    <h1>Tambah Kegiatan Baru</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('activities.store') }}" method="POST">
        @csrf
        
        <div>
    <label for="code">Kode Kegiatan (Unik):</label><br>
    <input type="text" name="code" id="code" value="{{ old('code') }}" required>
    @error('code')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    </div>
    <br>

        <div>
            <label>Judul Kegiatan (Min 5 Karakter):</label><br>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>
        <br>
        
        <div>
    <label for="category_id">Kategori:</label>
    <select name="category_id" id="category_id" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>

        <div>
            <label>Tanggal Kegiatan:</label><br>
            <input type="date" name="activity_date" value="{{ old('activity_date') }}" required>
        </div>
        <br>
        
        <div>
            <label>Status:</label><br>
           <select name="status">
            <option value="Draft">Draft</option>
            <option value="Published">Published</option>
            <option value="Completed">Completed</option>
           </select>
        </div>
        <br>
        
        <button type="submit">Simpan</button>
        <a href="{{ route('activities.index') }}">Batal</a>
    </form>
</body>
</html>