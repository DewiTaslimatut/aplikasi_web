<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @extends('layout.app')

    @section('title', 'Daftar Laporan')

    @section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Laporan</h1>

        <a href="{{ route('reports.create') }}" class="btn btn-primary mb-3">Generate Laporan Baru</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis Laporan</th>
                    <th>Periode</th>
                    <th>Department</th>
                    <th>Tanggal Generate</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>
                        @if($report->report_type == 'attendance')
                            <span class="badge bg-info">Laporan Kehadiran</span>
                        @elseif($report->report_type == 'salary')
                            <span class="badge bg-success">Laporan Gaji</span>
                        @else
                            <span class="badge bg-warning">Laporan Karyawan</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($report->period)->format('F Y') }}</td>
                    <td>{{ $report->department->nama_departemen ?? 'Semua Department' }}</td>
                    <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('reports.show', $report->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus laporan?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada laporan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endsection
</body>
</html>