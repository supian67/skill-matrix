<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat index pengganti untuk menjaga Foreign Key employee_id.
        Schema::table('assessments', function (Blueprint $table) {
            $table->index('employee_id', 'assessments_employee_id_index');
        });

        // 2. Setelah ada index pengganti, hapus unique index lama.
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropUnique('assessments_employee_id_skill_id_unique');
        });

        // 3. Tambahkan kolom periode penilaian.
        Schema::table('assessments', function (Blueprint $table) {
            $table->unsignedSmallInteger('period_year')
                ->nullable()
                ->after('assessed_at');

            $table->unsignedTinyInteger('period_quarter')
                ->nullable()
                ->after('period_year');
        });

        // 4. Isi periode data lama berdasarkan tanggal assessment.
        DB::table('assessments')->update([
            'period_year' => DB::raw('YEAR(assessed_at)'),
            'period_quarter' => DB::raw('QUARTER(assessed_at)'),
        ]);

        // 5. Buat aturan unik berdasarkan karyawan, skill, tahun, dan kuartal.
        Schema::table('assessments', function (Blueprint $table) {
            $table->unique(
                ['employee_id', 'skill_id', 'period_year', 'period_quarter'],
                'assessments_employee_skill_period_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropUnique('assessments_employee_skill_period_unique');
        });

        Schema::table('assessments', function (Blueprint $table) {
            $table->unique(
                ['employee_id', 'skill_id'],
                'assessments_employee_id_skill_id_unique'
            );
        });

        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn([
                'period_year',
                'period_quarter',
            ]);

            $table->dropIndex('assessments_employee_id_index');
        });
    }
};