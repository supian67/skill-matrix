<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Employee;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $skills = collect([
            ['name' => 'Active Listening', 'category' => 'Soft Skill', 'target_level' => 4],
            ['name' => 'Communication', 'category' => 'Soft Skill', 'target_level' => 4],
            ['name' => 'Problem Solving', 'category' => 'Soft Skill', 'target_level' => 4],
            ['name' => 'Quality Awareness', 'category' => 'Quality', 'target_level' => 4],
            ['name' => 'SOP Compliance', 'category' => 'Production', 'target_level' => 5],
            ['name' => 'Machine Operation', 'category' => 'Technical', 'target_level' => 4],
            ['name' => 'Teamwork', 'category' => 'Soft Skill', 'target_level' => 4],
            ['name' => '5S / Housekeeping', 'category' => 'Production', 'target_level' => 3],
        ])->map(fn ($item) => Skill::firstOrCreate(['name' => $item['name']], $item));

        $employees = collect([
            ['employee_no' => 'EMP-001', 'name' => 'Andi Saputra', 'department' => 'Sewing', 'position' => 'Operator', 'status' => 'Aktif'],
            ['employee_no' => 'EMP-002', 'name' => 'Siti Rahmawati', 'department' => 'Assembling', 'position' => 'Operator', 'status' => 'Aktif'],
            ['employee_no' => 'EMP-003', 'name' => 'Budi Santoso', 'department' => 'Cutting', 'position' => 'Leader', 'status' => 'Aktif'],
            ['employee_no' => 'EMP-004', 'name' => 'Dewi Lestari', 'department' => 'Quality', 'position' => 'Inspector', 'status' => 'Aktif'],
            ['employee_no' => 'EMP-005', 'name' => 'Rizky Firmansyah', 'department' => 'Sewing', 'position' => 'Operator', 'status' => 'Aktif'],
        ])->map(fn ($item) => Employee::firstOrCreate(['employee_no' => $item['employee_no']], $item));

        foreach ($employees as $i => $employee) {
            foreach ($skills as $j => $skill) {
                Assessment::updateOrCreate(
                    ['employee_id' => $employee->id, 'skill_id' => $skill->id],
                    [
                        'assessed_level' => min(5, 2 + (($i + $j) % 4)),
                        'target_level' => $skill->target_level,
                        'assessed_at' => now()->toDateString(),
                        'assessor' => 'HR / Supervisor',
                    ]
                );
            }
        }
    }
}
