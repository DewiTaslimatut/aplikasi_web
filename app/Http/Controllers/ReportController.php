<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\Salary;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('department')->latest()->get();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $departments = Department::all();
        $reportTypes = [
            'attendance' => 'Laporan Kehadiran',
            'salary' => 'Laporan Gaji',
            'employee' => 'Laporan Karyawan'
        ];
        
        return view('reports.create', compact('departments', 'reportTypes'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:attendance,salary,employee',
            'period' => 'required|date',
            'department_id' => 'nullable|exists:departments,id'
        ]);

        $reportType = $request->report_type;
        $period = $request->period;
        $departmentId = $request->department_id;

        // Generate report berdasarkan type
        switch ($reportType) {
            case 'attendance':
                $reportData = $this->generateAttendanceReport($period, $departmentId);
                break;
            case 'salary':
                $reportData = $this->generateSalaryReport($period, $departmentId);
                break;
            case 'employee':
                $reportData = $this->generateEmployeeReport($departmentId);
                break;
        }

        // Simpan report ke database
        $report = Report::create([
            'report_type' => $reportType,
            'period' => $period,
            'department_id' => $departmentId,
            'data' => $reportData,
            'generated_by' => auth()->id() // jika pakai auth
        ]);

        return view('reports.show', compact('report', 'reportData'));
    }

    private function generateAttendanceReport($period, $departmentId = null)
    {
        $startDate = Carbon::parse($period)->startOfMonth();
        $endDate = Carbon::parse($period)->endOfMonth();

        $query = Employee::with(['attendances' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }]);

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $employees = $query->get();

        $reportData = [];
        foreach ($employees as $employee) {
            $attendances = $employee->attendances;
            
            $reportData[] = [
                'employee_id' => $employee->id,
                'nama_lengkap' => $employee->nama_lengkap,
                'department' => $employee->department->nama_departemen ?? '-',
                'position' => $employee->position->nama_jabatan ?? '-',
                'total_hadir' => $attendances->where('status_absensi', 'hadir')->count(),
                'total_izin' => $attendances->where('status_absensi', 'izin')->count(),
                'total_sakit' => $attendances->where('status_absensi', 'sakit')->count(),
                'total_alpha' => $attendances->where('status_absensi', 'alpha')->count(),
                'persentase_kehadiran' => $this->calculateAttendancePercentage($attendances)
            ];
        }

        return $reportData;
    }

    private function generateSalaryReport($period, $departmentId = null)
    {
        $query = Employee::with(['position', 'department']);

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $employees = $query->get();

        $reportData = [];
        foreach ($employees as $employee) {
            // Hitung gaji berdasarkan position dan kehadiran
            $basicSalary = $employee->position->gaji_pokok ?? 0;
            $attendanceCount = $employee->attendances()
                ->whereMonth('tanggal', Carbon::parse($period)->month)
                ->whereYear('tanggal', Carbon::parse($period)->year)
                ->where('status_absensi', 'hadir')
                ->count();

            $totalSalary = $basicSalary * ($attendanceCount / 22); // Asumsi 22 hari kerja

            $reportData[] = [
                'employee_id' => $employee->id,
                'nama_lengkap' => $employee->nama_lengkap,
                'department' => $employee->department->nama_departemen ?? '-',
                'position' => $employee->position->nama_jabatan ?? '-',
                'basic_salary' => number_format($basicSalary, 0, ',', '.'),
                'total_kehadiran' => $attendanceCount,
                'total_gaji' => number_format($totalSalary, 0, ',', '.'),
                'periode' => Carbon::parse($period)->format('F Y')
            ];
        }

        return $reportData;
    }

    private function generateEmployeeReport($departmentId = null)
    {
        $query = Employee::with(['department', 'position']);

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $employees = $query->get();

        $reportData = [];
        foreach ($employees as $employee) {
            $reportData[] = [
                'employee_id' => $employee->id,
                'nama_lengkap' => $employee->nama_lengkap,
                'email' => $employee->email,
                'nomor_telepon' => $employee->nomor_telepon,
                'department' => $employee->department->nama_departemen ?? '-',
                'position' => $employee->position->nama_jabatan ?? '-',
                'tanggal_masuk' => $employee->tanggal_masuk,
                'status' => $employee->status
            ];
        }

        return $reportData;
    }

    private function calculateAttendancePercentage($attendances)
    {
        $totalDays = 22; // Asumsi hari kerja dalam sebulan
        $presentDays = $attendances->where('status_absensi', 'hadir')->count();
        
        return $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0;
    }

    public function show($id)
    {
        $report = Report::findOrFail($id);
        $reportData = $report->data;

        return view('reports.show', compact('report', 'reportData'));
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}