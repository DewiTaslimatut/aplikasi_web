<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::withCount('employees')
            ->orderBy('gaji_pokok', 'desc')
            ->get();
            
        return view('positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:positions,nama_jabatan',
            'gaji_pokok' => 'required|numeric|min:0'
        ]);

        Position::create([
            'nama_jabatan' => $request->nama_jabatan,
            'gaji_pokok' => $request->gaji_pokok
        ]);

        return redirect()->route('positions.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $position = Position::with('employees.department')->findOrFail($id);
        return view('positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $position = Position::findOrFail($id);
        return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:positions,nama_jabatan,' . $id,
            'gaji_pokok' => 'required|numeric|min:0'
        ]);

        $position->update([
            'nama_jabatan' => $request->nama_jabatan,
            'gaji_pokok' => $request->gaji_pokok
        ]);

        return redirect()->route('positions.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $position = Position::findOrFail($id);

        // Cek apakah ada employee yang menggunakan position ini
        if ($position->employees()->count() > 0) {
            return redirect()->route('positions.index')
                ->with('error', 'Tidak dapat menghapus jabatan karena masih ada karyawan yang menggunakan jabatan ini.');
        }

        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }

    /**
     * Update only salary
     */
    public function updateSalary(Request $request, $id)
    {
        $request->validate([
            'gaji_pokok' => 'required|numeric|min:0'
        ]);

        $position = Position::findOrFail($id);
        $position->update([
            'gaji_pokok' => $request->gaji_pokok
        ]);

        return redirect()->route('positions.index')
            ->with('success', 'Gaji pokok berhasil diperbarui.');
    }
}