<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        // dd($departments); // This will dump and die - showing all departments data
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
    //     dd([
    //     'all_data' => $request->all(),
    //     'has_nama_departemen' => $request->has('nama_departemen'),
    //     'nama_departemen_value' => $request->nama_departemen
    // ]);
        $validated = $request->validate([
            'nama_departemen' => 'required|max:100',
            // 'deskripsi' => 'nullable'
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|max:100',
            'deskripsi' => 'required'
        ]);

        $department = Department::findOrFail($id);
        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department berhasil dihapus');
    }
}
