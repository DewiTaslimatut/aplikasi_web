<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - {{ ucfirst($report->report_type) }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Detail Laporan</h4>
                        <div>
                            <a href="{{ route('reports.create') }}" class="btn btn-primary">Buat Laporan Baru</a>
                            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Laporan -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Informasi Laporan</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Jenis Laporan</th>
                                        <td>{{ ucfirst($report->report_type) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode</th>
                                        <td>{{ \Carbon\Carbon::parse($report->period)->format('F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Departemen</th>
                                        <td>{{ $report->department->nama_departemen ?? 'Semua Departemen' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Oleh</th>
                                        <td>{{ $report->generatedBy->name ?? 'System' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Dibuat</th>
                                        <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Data Laporan -->
                        <h5>Data Laporan</h5>
                        <div class="table-responsive">
                            @if($report->report_type === 'attendance')
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nama Karyawan</th>
                                            <th>Departemen</th>
                                            <th>Jabatan</th>
                                            <th>Hadir</th>
                                            <th>Izin</th>
                                            <th>Sakit</th>
                                            <th>Alpha</th>
                                            <th>Persentase Kehadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reportData as $data)
                                        <tr>
                                            <td>{{ $data['nama_lengkap'] }}</td>
                                            <td>{{ $data['department'] }}</td>
                                            <td>{{ $data['position'] }}</td>
                                            <td>{{ $data['total_hadir'] }}</td>
                                            <td>{{ $data['total_izin'] }}</td>
                                            <td>{{ $data['total_sakit'] }}</td>
                                            <td>{{ $data['total_alpha'] }}</td>
                                            <td>{{ $data['persentase_kehadiran'] }}%</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            @elseif($report->report_type === 'salary')
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nama Karyawan</th>
                                            <th>Departemen</th>
                                            <th>Jabatan</th>
                                            <th>Gaji Pokok</th>
                                            <th>Total Kehadiran</th>
                                            <th>Total Gaji</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reportData as $data)
                                        <tr>
                                            <td>{{ $data['nama_lengkap'] }}</td>
                                            <td>{{ $data['department'] }}</td>
                                            <td>{{ $data['position'] }}</td>
                                            <td>Rp {{ $data['basic_salary'] }}</td>
                                            <td>{{ $data['total_kehadiran'] }} hari</td>
                                            <td>Rp {{ $data['total_gaji'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            @elseif($report->report_type === 'employee')
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                            <th>Departemen</th>
                                            <th>Jabatan</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reportData as $data)
                                        <tr>
                                            <td>{{ $data['nama_lengkap'] }}</td>
                                            <td>{{ $data['email'] }}</td>
                                            <td>{{ $data['nomor_telepon'] }}</td>
                                            <td>{{ $data['department'] }}</td>
                                            <td>{{ $data['position'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($data['tanggal_masuk'])->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $data['status'] === 'active' ? 'success' : 'secondary' }}">
                                                    {{ $data['status'] === 'active' ? 'Aktif' : 'Non-Aktif' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4">
                            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="fas fa-print"></i> Cetak Laporan
                            </button>
                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                    <i class="fas fa-trash"></i> Hapus Laporan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
</body>
</html>