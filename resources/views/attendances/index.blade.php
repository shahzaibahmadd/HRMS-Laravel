@extends('layouts.App')

@section('title', 'Attendance - Laravel HRMS')
@section('page-title', 'Attendance Management')

@section('page-actions')
    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#checkInModal">
        <i class="fas fa-sign-in-alt me-2"></i>Check In
    </button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAttendanceModal">
        <i class="fas fa-plus me-2"></i>Add Attendance
    </button>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>Attendance Records
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="attendancesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Employee</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Duration</th>
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

<!-- Check In Modal -->
<div class="modal fade" id="checkInModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-sign-in-alt me-2"></i>Check In
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="checkInForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="checkin_employee_id" class="form-label">Select Employee</label>
                        <select class="form-select" id="checkin_employee_id" name="employee_id" required>
                            <option value="">Choose an employee...</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-sign-in-alt me-2"></i>Check In
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Attendance Modal -->
<div class="modal fade" id="createAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add Attendance Record
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createAttendanceForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select class="form-select" id="employee_id" name="employee_id" required>
                            <option value="">Choose an employee...</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="check_in_time" class="form-label">Check In Time</label>
                        <input type="datetime-local" class="form-control" id="check_in_time" name="check_in_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="check_out_time" class="form-label">Check Out Time</label>
                        <input type="datetime-local" class="form-control" id="check_out_time" name="check_out_time">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Attendance Modal -->
<div class="modal fade" id="editAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Attendance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAttendanceForm">
                <input type="hidden" id="edit_attendance_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_employee_id" class="form-label">Employee</label>
                        <select class="form-select" id="edit_employee_id" name="employee_id" required>
                            <option value="">Choose an employee...</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_check_in_time" class="form-label">Check In Time</label>
                        <input type="datetime-local" class="form-control" id="edit_check_in_time" name="check_in_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_check_out_time" class="form-label">Check Out Time</label>
                        <input type="datetime-local" class="form-control" id="edit_check_out_time" name="check_out_time">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let attendances = [];
    let employees = [];

    // Load data on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadEmployees();
        loadAttendances();
    });

    // Load employees from API
    async function loadEmployees() {
        try {
            const response = await axios.get(`${API_BASE_URL}/employees`);
            employees = response.data;
            populateEmployeeSelects();
        } catch (error) {
            console.error('Error loading employees:', error);
        }
    }

    // Populate employee select dropdowns
    function populateEmployeeSelects() {
        const selects = ['employee_id', 'edit_employee_id', 'checkin_employee_id'];

        selects.forEach(selectId => {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Choose an employee...</option>';

            employees.forEach(employee => {
                const option = document.createElement('option');
                option.value = employee.id;
                option.textContent = `${employee.first_name} ${employee.last_name}`;
                select.appendChild(option);
            });
        });
    }

    // Load attendances from API
    async function loadAttendances() {
        try {
            const response = await axios.get(`${API_BASE_URL}/attendances`);
            attendances = response.data;
            renderAttendancesTable();
        } catch (error) {
            console.error('Error loading attendances:', error);
            showAlert('Error loading attendances', 'danger');
        }
    }

    // Render attendances table
    function renderAttendancesTable() {
        const tbody = document.querySelector('#attendancesTable tbody');
        tbody.innerHTML = '';

        attendances.forEach(attendance => {
            const row = document.createElement('tr');
            const checkIn = new Date(attendance.check_in_time);
            const checkOut = attendance.check_out_time ? new Date(attendance.check_out_time) : null;
            const duration = checkOut ? calculateDuration(checkIn, checkOut) : 'In Progress';

            row.innerHTML = `
                <td>${attendance.id}</td>
                <td>${attendance.employee ? attendance.employee.first_name + ' ' + attendance.employee.last_name : 'N/A'}</td>
                <td>${checkIn.toLocaleString()}</td>
                <td>${checkOut ? checkOut.toLocaleString() : 'Not checked out'}</td>
                <td>${duration}</td>
                <td>
                    ${!checkOut ? `<button class="btn btn-sm btn-warning me-1" onclick="checkOut(${attendance.id})">
                        <i class="fas fa-sign-out-alt"></i> Check Out
                    </button>` : ''}
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editAttendance(${attendance.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteAttendance(${attendance.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Calculate duration between two dates
    function calculateDuration(start, end) {
        const diff = end - start;
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        return `${hours}h ${minutes}m`;
    }

    // Check in form submission
    document.getElementById('checkInForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await axios.post(`${API_BASE_URL}/attendances/check-in`, {
                employee_id: formData.get('employee_id')
            });

            showAlert('Employee checked in successfully!');
            bootstrap.Modal.getInstance(document.getElementById('checkInModal')).hide();
            this.reset();
            loadAttendances();
        } catch (error) {
            console.error('Error checking in:', error);
            showAlert('Error checking in employee', 'danger');
        }
    });

    // Create attendance form submission
    document.getElementById('createAttendanceForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        try {
            const response = await axios.post(`${API_BASE_URL}/attendances`, data);

            showAlert('Attendance record created successfully!');
            bootstrap.Modal.getInstance(document.getElementById('createAttendanceModal')).hide();
            this.reset();
            loadAttendances();
        } catch (error) {
            console.error('Error creating attendance:', error);
            showAlert('Error creating attendance record', 'danger');
        }
    });

    // Check out
    async function checkOut(id) {
        try {
            const response = await axios.patch(`${API_BASE_URL}/attendances/${id}/check-out`);
            showAlert('Employee checked out successfully!');
            loadAttendances();
        } catch (error) {
            console.error('Error checking out:', error);
            showAlert('Error checking out employee', 'danger');
        }
    }

    // Edit attendance
    function editAttendance(id) {
        const attendance = attendances.find(att => att.id === id);
        if (!attendance) return;

        document.getElementById('edit_attendance_id').value = attendance.id;
        document.getElementById('edit_employee_id').value = attendance.employee_id;

        // Format datetime for input
        const checkInDate = new Date(attendance.check_in_time);
        document.getElementById('edit_check_in_time').value = formatDateTimeLocal(checkInDate);

        if (attendance.check_out_time) {
            const checkOutDate = new Date(attendance.check_out_time);
            document.getElementById('edit_check_out_time').value = formatDateTimeLocal(checkOutDate);
        }

        new bootstrap.Modal(document.getElementById('editAttendanceModal')).show();
    }

    // Format date for datetime-local input
    function formatDateTimeLocal(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${year}-${month}-${day}T${hours}:${minutes}`;
    }

    // Edit attendance form submission
    document.getElementById('editAttendanceForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const attendanceId = formData.get('id');
        const data = Object.fromEntries(formData);
        delete data.id;

        try {
            const response = await axios.put(`${API_BASE_URL}/attendances/${attendanceId}`, data);

            showAlert('Attendance updated successfully!');
            bootstrap.Modal.getInstance(document.getElementById('editAttendanceModal')).hide();
            loadAttendances();
        } catch (error) {
            console.error('Error updating attendance:', error);
            showAlert('Error updating attendance', 'danger');
        }
    });

    // Delete attendance
    async function deleteAttendance(id) {
        if (!confirm('Are you sure you want to delete this attendance record?')) return;

        try {
            await axios.delete(`${API_BASE_URL}/attendances/${id}`);
            showAlert('Attendance record deleted successfully!');
            loadAttendances();
        } catch (error) {
            console.error('Error deleting attendance:', error);
            showAlert('Error deleting attendance record', 'danger');
        }
    }
</script>
@endsection

