<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'karyawan';

    public function up(): void
    {
        Schema::connection('karyawan')->table('employees', function (Blueprint $table) {
            if (!Schema::connection('karyawan')->hasColumn('employees', 'gender')) {
                $table->string('gender', 20)->nullable()->after('name');
            }

            if (!Schema::connection('karyawan')->hasColumn('employees', 'organization')) {
                $table->string('organization', 150)->nullable()->after('department');
            }
        });
    }

    public function down(): void
    {
        Schema::connection('karyawan')->table('employees', function (Blueprint $table) {
            if (Schema::connection('karyawan')->hasColumn('employees', 'organization')) {
                $table->dropColumn('organization');
            }

            if (Schema::connection('karyawan')->hasColumn('employees', 'gender')) {
                $table->dropColumn('gender');
            }
        });
    }
};