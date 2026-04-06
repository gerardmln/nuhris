<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $departmentId = $request->string('department_id')->toString();
        $status = $request->string('status')->toString();

        $employees = Employee::query()
            ->with('department')
            ->when($search, function ($query, $searchTerm) {
                $query->where(function ($nested) use ($searchTerm) {
                    $nested
                        ->where('employee_id', 'like', "%{$searchTerm}%")
                        ->orWhere('first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('last_name', 'like', "%{$searchTerm}%")
                        ->orWhere('email', 'like', "%{$searchTerm}%");
                });
            })
            ->when($departmentId, fn ($query, $department) => $query->where('department_id', $department))
            ->when($status, fn ($query, $employeeStatus) => $query->where('status', $employeeStatus))
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(10)
            ->withQueryString();

        return view('hr.employees', [
            'employees' => $employees,
            'departments' => Department::query()->schools()->orderBy('name')->get(),
            'employmentTypes' => config('hris.employment_types', []),
            'employeePositions' => array_values(array_unique(array_merge(
                config('hris.faculty_positions', []),
                config('hris.admin_support_offices', [])
            ))),
            'facultyRankings' => config('hris.faculty_rankings', []),
            'filters' => [
                'search' => $search,
                'department_id' => $departmentId,
                'status' => $status,
            ],
        ]);
    }

    public function create(): View
    {
        return view('hr.employees.create', [
            'departments' => Department::query()->schools()->orderBy('name')->get(),
            'employmentTypes' => config('hris.employment_types', []),
            'employeePositions' => array_values(array_unique(array_merge(
                config('hris.faculty_positions', []),
                config('hris.admin_support_offices', [])
            ))),
            'facultyRankings' => config('hris.faculty_rankings', []),
        ]);
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $payload = $request->validated();
        $payload = $this->applyDefaultDepartmentForNonTeachingRoles($payload);

        Employee::create($payload);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee): View
    {
        $employee->load('department');

        return view('hr.employees.show', [
            'employee' => $employee,
        ]);
    }

    public function edit(Employee $employee): View
    {
        return view('hr.employees.edit', [
            'employee' => $employee,
            'departments' => Department::query()->schools()->orderBy('name')->get(),
            'employmentTypes' => config('hris.employment_types', []),
            'employeePositions' => array_values(array_unique(array_merge(
                config('hris.faculty_positions', []),
                config('hris.admin_support_offices', [])
            ))),
            'facultyRankings' => config('hris.faculty_rankings', []),
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $payload = $request->validated();
        $payload = $this->applyDefaultDepartmentForNonTeachingRoles($payload);

        $employee->update($payload);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    private function applyDefaultDepartmentForNonTeachingRoles(array $payload): array
    {
        $position = Str::lower((string) ($payload['position'] ?? ''));
        $requiresDepartment = Str::contains($position, ['professor', 'dean', 'program chair']);

        if ($requiresDepartment) {
            return $payload;
        }

        $aspDepartmentId = Department::query()->where('name', 'ASP')->value('id');

        if (filled($aspDepartmentId)) {
            $payload['department_id'] = $aspDepartmentId;
        }

        return $payload;
    }
}
