<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>
</head>
<body>
    @extends('layout.app')

@section('title', 'Edit Department')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Edit Department</h1>

    <p><strong>Nama Department Sebelumnya:</strong> {{ $department->nama_departemen }}</p> <!-- Menampilkan nama awal -->
    <p>Silakan ubah nama department jika diperlukan. Setelah selesai, klik tombol "Update" untuk menyimpan perubahan.</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('departments.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_department" class="form-label">Nama Department:</label>
            <input type="text" id="nama_department" name="nama_department" class="form-control" value="{{ old('nama_department', $department->nama_department) }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $department->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
</body>
</html>
