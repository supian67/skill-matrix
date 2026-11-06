<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeesImport;
use Illuminate\Support\Facades\File;

class EmployeesSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data_karyawan.xlsx');

        if (!File::exists($file)) {
            $this->command->error(
                'File data_karyawan.xlsx tidak ditemukan!'
            );
            return;
        }

        $import = new EmployeesImport();

        Excel::import($import, $file);

        $this->command->info(
            'Data berhasil diproses: ' . $import->berhasil
        );

        $this->command->warn(
            'Data dilewati: ' . $import->dilewati
        );

        $this->command->info(
            'Total data di database: ' .
            \App\Models\HrisEmployee::count()
        );
    }
}