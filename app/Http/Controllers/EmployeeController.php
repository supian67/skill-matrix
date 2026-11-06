<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::query()
            ->when($request->search, fn ($q, $s) => $q->where(fn ($x) => $x
                ->where('name', 'like', "%{$s}%")
                ->orWhere('employee_no', 'like', "%{$s}%")))
            ->when($request->department, fn ($q, $d) => $q->where('department', $d))
            ->latest()->paginate(12)->withQueryString();

        $departments = Employee::query()->whereNotNull('department')->distinct()->orderBy('department')->pluck('department');
        return view('employees.index', compact('employees', 'departments'));
    }

    public function create() { return view('employees.form', ['employee' => new Employee]); }

    public function store(Request $request)
    {
        Employee::create($this->validated($request));
        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit(Employee $employee) { return view('employees.form', compact('employee')); }

    public function update(Request $request, Employee $employee)
    {
        $employee->update($this->validated($request, $employee));
        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'Data karyawan berhasil dihapus.');
    }

    private function validated(Request $request, ?Employee $employee = null): array
    {
        return $request->validate([
            'employee_no' => ['required', 'string', 'max:40', Rule::unique('employees', 'employee_no')->ignore($employee?->id)],
            'name' => ['required', 'string', 'max:150'],
            'department' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:150'],
            'status' => ['required', Rule::in(['Aktif', 'Nonaktif'])],
            'join_date' => ['nullable', 'date'],
        ]);
    }
}
