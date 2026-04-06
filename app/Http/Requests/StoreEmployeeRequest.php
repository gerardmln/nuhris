<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $employmentTypes = config('hris.employment_types', []);
        $positions = array_values(array_unique(array_merge(
            config('hris.faculty_positions', []),
            config('hris.admin_support_offices', [])
        )));
        $rankings = config('hris.faculty_rankings', []);
        $selectedPosition = Str::lower((string) $this->input('position'));
        $requiresDepartment = Str::contains($selectedPosition, ['professor', 'dean', 'program chair']);
        $requiresRanking = Str::contains($selectedPosition, 'professor');

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:employees,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'department_id' => [Rule::requiredIf($requiresDepartment), 'nullable', 'exists:departments,id'],
            'position' => ['required', Rule::in($positions)],
            'employment_type' => ['required', Rule::in($employmentTypes)],
            'ranking' => [
                Rule::requiredIf($requiresRanking),
                'nullable',
                Rule::in($rankings),
            ],
            'status' => ['required', 'in:active,on_leave,resigned,terminated'],
            'hire_date' => ['nullable', 'date'],
            'official_time_in' => ['nullable', 'date_format:H:i'],
            'official_time_out' => ['nullable', 'date_format:H:i'],
            'resume_last_updated_at' => ['nullable', 'date'],
        ];
    }
}
