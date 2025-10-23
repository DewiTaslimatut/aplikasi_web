<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_type',
        'period',
        'department_id',
        'data',
        'generated_by'
    ];

    protected $casts = [
        'data' => 'array',
        'period' => 'date'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(Employee::class, 'generated_by');
    }
}