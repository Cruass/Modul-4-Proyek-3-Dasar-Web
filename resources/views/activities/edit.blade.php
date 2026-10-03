<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kegiatan</title>
</head>
<body>
    <h1>Edit Kegiatan</h1>

    @if(session('error'))
    <div style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px;">
        {{ session('error') }}
    </div>
@endif
    
<form action="{{ route('activities.update', $activity->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label for="code">Kode Kegiatan (Unik):</label><br>
            <input type="text" name="code" id="code" value="{{ old('code', $activity->code ?? '') }}" required>
            @error('code')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>

        <div>
            <label>Judul Kegiatan (Min 5 Karakter):</label><br>
            <input type="text" name="title" value="{{ old('title', $activity->title) }}" required>
        </div>
        <br>
        
        <div>
            <label>Tanggal Kegiatan:</label><br>
            <input type="date" name="activity_date" value="{{ old('activity_date', $activity->activity_date) }}" required>
        </div>
        <br>
        
        <div>
           <label>Status:</label>
            <select name="status">
                <option value="Draft" {{ $activity->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Published" {{ $activity->status == 'Published' ? 'selected' : '' }}>Published</option>
                <option value="Completed" {{ $activity->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <br>
        
        <div>
            <label for="category_id">Kategori:</label>
            <select name="category_id" id="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $activity->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>

        <button type="submit">Update Data</button>
        <a href="{{ route('activities.index') }}">Batal</a>
    </form>
</body>
</html>