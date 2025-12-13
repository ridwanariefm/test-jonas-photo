<!DOCTYPE html>
<html>

<head>
    <title>Edit Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-5">
    <h1>Edit Foto</h1>

    <form action="{{ route('photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" value="{{ $photo->title }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control">{{ $photo->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Gambar Saat Ini:</label><br>
            <img src="{{ asset('storage/' . $photo->image_path) }}" width="150" class="mb-2 rounded">
            <br>
            <label>Ganti Gambar (Kosongkan jika tidak ingin mengganti)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-warning">Update Perubahan</button>
        <a href="{{ route('photos.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</body>

</html>