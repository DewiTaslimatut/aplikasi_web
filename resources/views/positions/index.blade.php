<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jabatan & Gaji - App Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('employees.index') }}">
                                <i class="fas fa-users me-2"></i>
                                Data Pegawai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('attendances.index') }}">
                                <i class="fas fa-calendar-check me-2"></i>
                                Absensi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('departments.index') }}">
                                <i class="fas fa-building me-2"></i>
                                Departemen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="{{ route('positions.index') }}">
                                <i class="fas fa-briefcase me-2"></i>
                                Jabatan & Gaji
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('reports.index') }}">
                                <i class="fas fa-chart-bar me-2"></i>
                                Laporan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-briefcase me-2"></i>
                        Data Jabatan & Gaji
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('positions.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Tambah Jabatan
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>
                            Daftar Jabatan dan Gaji Pokok
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Nama Jabatan</th>
                                        <th width="25%">Gaji Pokok</th>
                                        <th width="20%">Jumlah Karyawan</th>
                                        <th width="25%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($positions as $position)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $position->nama_jabatan }}</strong>
                                        </td>
                                        <td>
                                            <form action="{{ route('positions.update', $position->id) }}" method="POST" class="d-flex align-items-center">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" 
                                                           name="gaji_pokok" 
                                                           value="{{ $position->gaji_pokok }}" 
                                                           class="form-control"
                                                           min="0"
                                                           step="100000"
                                                           required>
                                                </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $position->employees_count }} karyawan
                                            </span>
                                        </td>
                                        <td>
                                                <button type="submit" class="btn btn-success btn-sm me-1">
                                                    <i class="fas fa-save me-1"></i> Update Gaji
                                                </button>
                                            </form>
                                            <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-warning btn-sm me-1">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <a href="{{ route('positions.show', $position->id) }}" class="btn btn-info btn-sm me-1">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                            <form action="{{ route('positions.destroy', $position->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus jabatan ini?')">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Total Jabatan</h6>
                                        <h3>{{ $positions->count() }}</h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-briefcase fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Gaji Tertinggi</h6>
                                        <h5>Rp {{ number_format($positions->max('gaji_pokok'), 0, ',', '.') }}</h5>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-arrow-up fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Gaji Terendah</h6>
                                        <h5>Rp {{ number_format($positions->min('gaji_pokok'), 0, ',', '.') }}</h5>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-arrow-down fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title">Rata-rata Gaji</h6>
                                        <h5>Rp {{ number_format($positions->avg('gaji_pokok'), 0, ',', '.') }}</h5>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-calculator fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto format input saat focus out
        document.querySelectorAll('input[name="gaji_pokok"]').forEach(input => {
            input.addEventListener('blur', function() {
                const value = parseInt(this.value);
                if (!isNaN(value)) {
                    this.value = value.toLocaleString('id-ID');
                }
            });
            
            input.addEventListener('focus', function() {
                this.value = this.value.replace(/\./g, '');
            });
        });

        // Confirm delete
        function confirmDelete(event) {
            if (!confirm('Apakah Anda yakin ingin menghapus jabatan ini?')) {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>