<?php

namespace App\Imports;

use App\Models\HrisEmployee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToCollection, WithHeadingRow
{
    public int $berhasil = 0;
    public int $dilewati = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $nik = trim((string) ($row['nik'] ?? ''));
            $nama = trim((string) ($row['nama'] ?? ''));

            if ($nik === '' || $nama === '') {
                $this->dilewati++;
                continue;
            }

            HrisEmployee::updateOrCreate(
                ['employee_no' => $nik],
                [
                    'name' => $nama,
                    'gender' => $row['gender'] ?? null,
                    'position' => $row['job_position'] ?? null,
                    'department' => $row['departemen'] ?? null,
                    'organization' => $row['nama_organisasi'] ?? null,
                ]
            );

            $this->berhasil++;
        }
    }
}