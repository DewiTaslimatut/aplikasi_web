<!DOCTYPE html>
<html>
<head>
    <title>Create Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @extends('layout.app')
    @section('title', 'Daftar Pegawai')
    @section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Input Department</h1>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_departemen" class="form-label">Nama Department:</label>
                <input type="text" class="form-control" id="nama_departemen" name="nama_departemen" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>