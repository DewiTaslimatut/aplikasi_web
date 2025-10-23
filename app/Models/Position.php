<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok'
    ];

    // Accessor untuk kompatibilitas
    public function getNamaAttribute()
    {
        return $this->nama_jabatan;
    }

    public function getBasicSalaryAttribute()
    {
        return $this->gaji_pokok;
    }

    // Relasi ke employees
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}