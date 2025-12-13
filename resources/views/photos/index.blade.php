<!DOCTYPE html>
<html>

<head>
    <title>Daftar Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-5">

    <div class="d-flex justify-content-between mb-4">
        <h1>Galeri Foto Jonas</h1>
        <a href="{{ route('photos.create') }}" class="btn btn-primary">
            + Upload Foto Baru
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul & Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($photos as $photo)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="width: 200px;">
                        <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->title }}"
                            class="img-fluid rounded shadow-sm">
                    </td>
                    <td>
                        <h5>{{ $photo->title }}</h5>
                        <p class="text-muted">{{ $photo->description }}</p>
                    </td>

                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form onsubmit="return confirm('Apakah anda yakin ?');"
                                action="{{ route('photos.destroy', $photo->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada foto. Yuk upload!</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>