<?php

namespace App\Http\Controllers;

use App\Models\Attendance; 
use App\Models\Employee; 
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::with('employee')->get(); // Mengambil semua data kehadiran dengan relasi employee
        return view('attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all(); // Mengambil semua karyawan untuk dropdown
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'karyawan_id' => 'required|exists:employees,id', // GUNAKAN karyawan_id
        'tanggal' => 'required|date',
        'waktu_masuk' => 'nullable|date_format:H:i',
        'waktu_keluar' => 'nullable|date_format:H:i',
        'status_absensi' => 'required|string|in:hadir,izin,sakit,alpha', // GUNAKAN status_absensi
    ]);

        Attendance::create($validated); // Menyimpan data kehadiran
        return redirect()->route('attendance.index')->with('success', 'Kehadiran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attendance = Attendance::findOrFail($id); // Menampilkan detail kehadiran
        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attendance = Attendance::findOrFail($id); // Mengambil data kehadiran yang akan diedit
        $employees = Employee::all(); // Mengambil semua karyawan untuk dropdown
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    //     dd([
    //     'request_data' => $request->all(),
    //     'attendance_id' => $id,
    //     'method' => $request->method(),
    //     'karyawan_id_value' => $request->karyawan_id,
    //     'tanggal_value' => $request->tanggal,
    //     'status_absensi_value' => $request->status_absensi,
    //     'has_karyawan_id' => $request->has('karyawan_id')
    // ]);
        $validated = $request->validate([
        'karyawan_id' => 'required|exists:employees,id',
        'tanggal' => 'required|date',
        'waktu_masuk' => 'nullable|date_format:H:i',
        'waktu_keluar' => 'nullable|date_format:H:i',
        'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
    ]);

    $attendance = Attendance::findOrFail($id);
    $attendance->update($validated);

    return redirect()->route('attendances.index')
        ->with('success', 'Data kehadiran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete(); // Menghapus data kehadiran
        return redirect()->route('attendance.index')->with('success', 'Kehadiran berhasil dihapus.');
    }
}
