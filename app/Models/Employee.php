<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'status',
        'department_id',
        'position_id',
        ];
    public function department()
{
    return $this->belongsTo(Department::class);
}

public function jabatan()
{
    return $this->belongsTo(Position::class, 'jabatan_id');
}
 public function attendances()
    {
        return $this->hasMany(Attendance::class, 'karyawan_id');
    }
     public function position()
    {
        return $this->belongsTo(Position::class);
    }

}
