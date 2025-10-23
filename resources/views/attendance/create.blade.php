<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
</head>
<body>
    @extends('layout.app')
    @section('title', 'Tambah Kehadiran')
    @section('content')
    <form action="{{ route('attendances.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="karyawan_id" class="form-label">Karyawan</label> <!-- GUNAKAN karyawan_id -->
        <select name="karyawan_id" id="karyawan_id" class="form-control" required>
            <option value="">Pilih Karyawan</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->nama_lengkap }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label for="waktu_masuk" class="form-label">Waktu Masuk</label>
        <input type="time" name="waktu_masuk" id="waktu_masuk" class="form-control">
    </div>
    
    <div class="mb-3">
        <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
        <input type="time" name="waktu_keluar" id="waktu_keluar" class="form-control">
    </div>
    
    <div class="mb-3">
        <label for="status_absensi" class="form-label">Status Absensi</label> <!-- GUNAKAN status_absensi -->
        <select name="status_absensi" id="status_absensi" class="form-control" required>
            <option value="">Pilih Status</option>
            <option value="hadir">Hadir</option>
            <option value="izin">Izin</option>
            <option value="sakit">Sakit</option>
            <option value="alpha">Alpha</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Kembali</a>
</form>
</body>
</html>

