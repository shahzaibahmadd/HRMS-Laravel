@extends('layouts.App')

@section('title', 'Employees - Laravel HRMS')
@section('page-title', 'Employees')

@section('page-actions')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEmployeeModal">
        <i class="fas fa-plus me-2"></i>Add Employee
    </button>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>Employee List
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="employeesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Job Title</th>
                                <th>Hire Date</th>
                                <th>Salary</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Employee Modal -->
<div class="modal fade" id="createEmployeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Add New Employee
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createEmployeeForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="job_title" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="job_title" name="job_title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hire_date" class="form-label">Hire Date</label>
                                <input type="date" class="form-control" id="hire_date" name="hire_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="salary" class="form-label">Salary</label>
                                <input type="number" step="0.01" class="form-control" id="salary" name="salary" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2"></i>Edit Employee
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editEmployeeForm" enctype="multipart/form-data">
                <input type="hidden" id="edit_employee_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_phone_number" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="edit_phone_number" name="phone_number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_job_title" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="edit_job_title" name="job_title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_hire_date" class="form-label">Hire Date</label>
                                <input type="date" class="form-control" id="edit_hire_date" name="hire_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_salary" class="form-label">Salary</label>
                                <input type="number" step="0.01" class="form-control" id="edit_salary" name="salary" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="edit_profile_picture" name="profile_picture" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let employees = [];

    // Load employees on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadEmployees();
    });

    // Load employees from API
    async function loadEmployees() {
        try {
            const response = await axios.get(`${API_BASE_URL}/employees`);
            employees = response.data;
            renderEmployeesTable();
        } catch (error) {
            console.error('Error loading employees:', error);
            showAlert('Error loading employees', 'danger');
        }
    }

    // Render employees table
    function renderEmployeesTable() {
        const tbody = document.querySelector('#employeesTable tbody');
        tbody.innerHTML = '';

        employees.forEach(employee => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${employee.id}</td>
                <td>${employee.first_name} ${employee.last_name}</td>
                <td>${employee.email}</td>
                <td>${employee.job_title}</td>
                <td>${new Date(employee.hire_date).toLocaleDateString()}</td>
                <td>$${parseFloat(employee.salary).toLocaleString()}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editEmployee(${employee.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteEmployee(${employee.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Create employee form submission
    document.getElementById('createEmployeeForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await axios.post(`${API_BASE_URL}/employees`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            showAlert('Employee created successfully!');
            bootstrap.Modal.getInstance(document.getElementById('createEmployeeModal')).hide();
            this.reset();
            loadEmployees();
        } catch (error) {
            console.error('Error creating employee:', error);
            showAlert('Error creating employee', 'danger');
        }
    });

    // Edit employee
    function editEmployee(id) {
        const employee = employees.find(emp => emp.id === id);
        if (!employee) return;

        document.getElementById('edit_employee_id').value = employee.id;
        document.getElementById('edit_first_name').value = employee.first_name;
        document.getElementById('edit_last_name').value = employee.last_name;
        document.getElementById('edit_email').value = employee.email;
        document.getElementById('edit_phone_number').value = employee.phone_number || '';
        document.getElementById('edit_job_title').value = employee.job_title;
        document.getElementById('edit_hire_date').value = employee.hire_date;
        document.getElementById('edit_salary').value = employee.salary;

        new bootstrap.Modal(document.getElementById('editEmployeeModal')).show();
    }

    // Edit employee form submission
    document.getElementById('editEmployeeForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const employeeId = formData.get('id');

        try {
            const response = await axios.post(`${API_BASE_URL}/employees/${employeeId}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-HTTP-Method-Override': 'PUT'
                }
            });

            showAlert('Employee updated successfully!');
            bootstrap.Modal.getInstance(document.getElementById('editEmployeeModal')).hide();
            loadEmployees();
        } catch (error) {
            console.error('Error updating employee:', error);
            showAlert('Error updating employee', 'danger');
        }
    });

    // Delete employee
    async function deleteEmployee(id) {
        if (!confirm('Are you sure you want to delete this employee?')) return;

        try {
            await axios.delete(`${API_BASE_URL}/employees/${id}`);
            showAlert('Employee deleted successfully!');
            loadEmployees();
        } catch (error) {
            console.error('Error deleting employee:', error);
            showAlert('Error deleting employee', 'danger');
        }
    }
</script>
@endsection

