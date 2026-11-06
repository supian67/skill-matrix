<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\HrisEmployee;
use App\Models\Employee;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| LOGIN DAN REGISTRASI
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Halaman Login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    // Proses Login
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    // Halaman Registrasi
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    // Proses Registrasi
    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');

     Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');

Route::put('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');   

});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| APLIKASI HRM SKILL MATRIX
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/', DashboardController::class)
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Lookup Karyawan dari HRIS
    |--------------------------------------------------------------------------
    */

    Route::get('/employees/lookup/{nik}', function ($nik) {

        // Cari karyawan di database HRIS
        $hris = HrisEmployee::where('employee_no', $nik)->first();

        if (!$hris) {
            return response()->json([
                'success' => false,
                'message' => 'NIK tidak ditemukan di database HRIS.',
            ], 404);
        }

        // Sinkronisasi ke database Skill Matrix
        $employee = Employee::firstOrNew([
            'employee_no' => $hris->employee_no,
        ]);

        $employee->name = $hris->name;
        $employee->department = $hris->department;
        $employee->position = $hris->position;
        $employee->status = 'Aktif';

        $employee->save();

        return response()->json([
            'success' => true,
            'data' => [
                'employee_id' => $employee->id,
                'employee_no' => $hris->employee_no,
                'name' => $hris->name,
                'gender' => $hris->gender,
                'department' => $hris->department,
                'position' => $hris->position,
                'organization' => $hris->organization,
            ],
        ]);

    })->name('employees.lookup');

    /*
    |--------------------------------------------------------------------------
    | Master Skill
    |--------------------------------------------------------------------------
    */

    Route::resource('skills', SkillController::class);

    /*
    |--------------------------------------------------------------------------
    | Assessment
    |--------------------------------------------------------------------------
    */

    Route::resource('assessments', AssessmentController::class)
        ->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */

    Route::get('/skill-gap', [ReportController::class, 'skillGap'])
        ->name('reports.skill-gap');

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

});