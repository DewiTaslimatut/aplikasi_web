<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kehadiran Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @extends('layout.app')

    @section('title', 'Daftar Kehadiran Karyawan')

    @section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Kehadiran Karyawan</h1>

        <a href="{{ route('attendances.create') }}" class="btn btn-primary mb-3">Tambah Kehadiran</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Status Kehadiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->id }}</td>
                    <td>
                        @if($attendance->employee)
                            {{ $attendance->employee->nama_lengkap }}
                        @else
                            <span class="text-danger">Karyawan tidak ditemukan</span>
                        @endif
                    </td>
                    <td>{{ $attendance->tanggal }}</td>
                    <td>{{ $attendance->waktu_masuk ?? '-' }}</td>
                    <td>{{ $attendance->waktu_keluar ?? '-' }}</td>
                    <td>
                        @if($attendance->status_absensi == 'hadir')
                            <span class="badge bg-success">Hadir</span>
                        @elseif($attendance->status_absensi == 'izin')
                            <span class="badge bg-warning">Izin</span>
                        @elseif($attendance->status_absensi == 'sakit')
                            <span class="badge bg-info">Sakit</span>
                        @elseif($attendance->status_absensi == 'alpha')
                            <span class="badge bg-danger">Alpha</span>
                        @else
                            <span class="badge bg-secondary">{{ $attendance->status_absensi }}</span>
                        @endif
                    </td>
                    <td>
                        <!-- PERBAIKI: attendance.edit MENJADI attendances.edit -->
                        <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <!-- PERBAIKI: attendance.destroy MENJADI attendances.destroy -->
                        <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data kehadiran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endsection
</body>
</html>