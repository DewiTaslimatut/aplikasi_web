<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @extends('layout.app')

    @section('title', 'Generate Laporan')

    @section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Generate Laporan Baru</h1>

        <form action="{{ route('reports.generate') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="report_type" class="form-label">Jenis Laporan</label>
                        <select name="report_type" id="report_type" class="form-control" required>
                            <option value="">Pilih Jenis Laporan</option>
                            <option value="attendance">Laporan Kehadiran</option>
                            <option value="salary">Laporan Gaji</option>
                            <option value="employee">Laporan Data Karyawan</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="period" class="form-label">Periode</label>
                        <input type="month" name="period" id="period" class="form-control" required 
                               value="{{ date('Y-m') }}">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department (Opsional)</label>
                        <select name="department_id" id="department_id" class="form-control">
                            <option value="">Semua Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->nama_departemen }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Generate Laporan</button>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    @endsection
</body>
</html>