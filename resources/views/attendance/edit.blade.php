<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kehadiran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @extends('layout.app')

    @section('title', 'Edit Kehadiran')

    @section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Edit Data Kehadiran</h1>
        <div class="alert alert-info">
            <strong>Perhatian:</strong> Silakan perbarui informasi kehadiran karyawan di bawah ini. Setelah selesai, klik tombol "Update" untuk menyimpan perubahan.
    </div>

        <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="karyawan_id" class="form-label">Karyawan</label>
                <select name="karyawan_id" id="karyawan_id" class="form-control" required>
                <option value="">Pilih Karyawan</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}"  
                        {{ $attendance->karyawan_id == $employee->id ? 'selected' : '' }}>
                        {{ $employee->nama_lengkap }}
                    </option>
                @endforeach
            </select>
            </div>
            
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" 
                    value="{{ $attendance->tanggal }}" required>
            </div>
            
            <div class="mb-3">
                <label for="waktu_masuk" class="form-label">Waktu Masuk</label>
                <input type="time" name="waktu_masuk" id="waktu_masuk" class="form-control" 
                    value="{{ $attendance->waktu_masuk }}">
            </div>
            
            <div class="mb-3">
                <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
                <input type="time" name="waktu_keluar" id="waktu_keluar" class="form-control" 
                    value="{{ $attendance->waktu_keluar }}">
            </div>
            
            <div class="mb-3">
                <label for="status_absensi" class="form-label">Status Kehadiran</label>
                <select name="status_absensi" id="status_absensi" class="form-control" required>
                    <option value="hadir" {{ $attendance->status_absensi == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ $attendance->status_absensi == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ $attendance->status_absensi == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="alpha" {{ $attendance->status_absensi == 'alpha' ? 'selected' : '' }}>Alpha</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    @endsection
</body>
</html>