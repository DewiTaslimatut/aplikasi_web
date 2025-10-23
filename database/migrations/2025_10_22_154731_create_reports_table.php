<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            // Hapus kolom yang tidak diperlukan
            $table->dropColumn(['title', 'content']);
            
            // Tambahkan kolom baru yang diperlukan
            $table->string('report_type')->after('id'); // attendance, salary, employee
            $table->date('period')->after('report_type');
            $table->foreignId('department_id')->nullable()->after('period')->constrained('departments')->onDelete('cascade');
            $table->json('data')->after('department_id');
            $table->foreignId('generated_by')->nullable()->after('data')->constrained('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            // Kembalikan kolom lama
            $table->string('title');
            $table->text('content');
            
            // Hapus kolom baru
            $table->dropColumn(['report_type', 'period', 'department_id', 'data', 'generated_by']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['generated_by']);
        });
    }
};