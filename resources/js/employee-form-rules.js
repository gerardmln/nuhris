const normalize = (value) => String(value ?? '').trim().toLowerCase();

const teachingKeywords = ['professor', 'dean', 'program chair'];

function isTeachingPosition(position) {
    const normalized = normalize(position);

    return teachingKeywords.some((keyword) => normalized.includes(keyword));
}

function isProfessorPosition(position) {
    return normalize(position).includes('professor');
}

function getControl(form, name) {
    return form.querySelector(`[data-employee-control="${name}"]`);
}

function getField(form, name) {
    return form.querySelector(`[data-employee-field="${name}"]`);
}

function updateEmployeeFormState(form) {
    const position = getControl(form, 'position')?.value ?? '';

    const departmentField = getField(form, 'department');
    const departmentControl = getControl(form, 'department');
    const rankingField = getField(form, 'ranking');
    const rankingControl = getControl(form, 'ranking');

    const needsDepartment = isTeachingPosition(position);
    const needsRanking = isProfessorPosition(position);

    if (departmentField && departmentControl) {
        departmentField.classList.toggle('hidden', !needsDepartment);
        departmentControl.required = needsDepartment;

        if (!needsDepartment) {
            departmentControl.value = '';
        }
    }

    if (rankingField && rankingControl) {
        rankingField.classList.toggle('hidden', !needsRanking);
        rankingControl.required = needsRanking;

        if (!needsRanking) {
            rankingControl.value = '';
        }
    }
}

function initializeEmployeeForm(form) {
    const typeControl = getControl(form, 'employment_type');
    const positionControl = getControl(form, 'position');

    if (!positionControl) {
        return;
    }

    const handleChange = () => updateEmployeeFormState(form);

    positionControl.addEventListener('change', handleChange);

    if (typeControl) {
        typeControl.addEventListener('change', handleChange);
    }

    updateEmployeeFormState(form);
}

function initializeEmployeeForms() {
    document.querySelectorAll('[data-employee-form]').forEach((form) => {
        initializeEmployeeForm(form);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeEmployeeForms);
} else {
    initializeEmployeeForms();
}