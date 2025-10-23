<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Hapus tabel reports jika ada
        Schema::dropIfExists('reports');
        
        // Buat tabel reports dengan struktur yang benar
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_type'); // attendance, salary, employee
            $table->date('period');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->json('data');
            $table->foreignId('generated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
};