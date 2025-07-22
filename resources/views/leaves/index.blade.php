@extends('layouts.App')

@section('title', 'Leave Management - Laravel HRMS')
@section('page-title', 'Leave Management')

@section('page-actions')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createLeaveModal">
        <i class="fas fa-plus me-2"></i>Request Leave
    </button>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Leave Requests
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="leavesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Days</th>
                                <th>Status</th>
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

<!-- Create Leave Modal -->
<div class="modal fade" id="createLeaveModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-plus me-2"></i>Request Leave
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createLeaveForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="employee_id" class="form-label">Employee</label>
                                <select class="form-select" id="employee_id" name="employee_id" required>
                                    <option value="">Choose an employee...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="leave_type" class="form-label">Leave Type</label>
                                <select class="form-select" id="leave_type" name="leave_type" required>
                                    <option value="">Choose leave type...</option>
                                    <option value="Annual Leave">Annual Leave</option>
                                    <option value="Sick Leave">Sick Leave</option>
                                    <option value="Personal Leave">Personal Leave</option>
                                    <option value="Maternity Leave">Maternity Leave</option>
                                    <option value="Paternity Leave">Paternity Leave</option>
                                    <option value="Emergency Leave">Emergency Leave</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Please provide a reason for your leave request..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Leave Modal -->
<div class="modal fade" id="editLeaveModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Leave Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editLeaveForm">
                <input type="hidden" id="edit_leave_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_employee_id" class="form-label">Employee</label>
                                <select class="form-select" id="edit_employee_id" name="employee_id" required>
                                    <option value="">Choose an employee...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_leave_type" class="form-label">Leave Type</label>
                                <select class="form-select" id="edit_leave_type" name="leave_type" required>
                                    <option value="">Choose leave type...</option>
                                    <option value="Annual Leave">Annual Leave</option>
                                    <option value="Sick Leave">Sick Leave</option>
                                    <option value="Personal Leave">Personal Leave</option>
                                    <option value="Maternity Leave">Maternity Leave</option>
                                    <option value="Paternity Leave">Paternity Leave</option>
                                    <option value="Emergency Leave">Emergency Leave</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_reason" class="form-label">Reason</label>
                        <textarea class="form-control" id="edit_reason" name="reason" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let leaves = [];
    let employees = [];

    // Load data on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadEmployees();
        loadLeaves();
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
        const selects = ['employee_id', 'edit_employee_id'];

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

    // Load leaves from API
    async function loadLeaves() {
        try {
            const response = await axios.get(`${API_BASE_URL}/leaves`);
            leaves = response.data;
            renderLeavesTable();
        } catch (error) {
            console.error('Error loading leaves:', error);
            showAlert('Error loading leave requests', 'danger');
        }
    }

    // Render leaves table
    function renderLeavesTable() {
        const tbody = document.querySelector('#leavesTable tbody');
        tbody.innerHTML = '';

        leaves.forEach(leave => {
            const row = document.createElement('tr');
            const startDate = new Date(leave.start_date);
            const endDate = new Date(leave.end_date);
            const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;

            row.innerHTML = `
                <td>${leave.id}</td>
                <td>${leave.employee ? leave.employee.first_name + ' ' + leave.employee.last_name : 'N/A'}</td>
                <td>${leave.leave_type}</td>
                <td>${startDate.toLocaleDateString()}</td>
                <td>${endDate.toLocaleDateString()}</td>
                <td>${days} day${days !== 1 ? 's' : ''}</td>
                <td>
                    <span class="status-badge status-${leave.status}">
                        ${leave.status.charAt(0).toUpperCase() + leave.status.slice(1)}
                    </span>
                </td>
                <td>
                    ${leave.status === 'pending' ? `
                        <button class="btn btn-sm btn-success me-1" onclick="approveLeave(${leave.id})" title="Approve">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn btn-sm btn-danger me-1" onclick="rejectLeave(${leave.id})" title="Reject">
                            <i class="fas fa-times"></i>
                        </button>
                    ` : ''}
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editLeave(${leave.id})" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteLeave(${leave.id})" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Create leave form submission
    document.getElementById('createLeaveForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        try {
            const response = await axios.post(`${API_BASE_URL}/leaves`, data);

            showAlert('Leave request submitted successfully!');
            bootstrap.Modal.getInstance(document.getElementById('createLeaveModal')).hide();
            this.reset();
            loadLeaves();
        } catch (error) {
            console.error('Error creating leave:', error);
            showAlert('Error submitting leave request', 'danger');
        }
    });

    // Edit leave
    function editLeave(id) {
        const leave = leaves.find(l => l.id === id);
        if (!leave) return;

        document.getElementById('edit_leave_id').value = leave.id;
        document.getElementById('edit_employee_id').value = leave.employee_id;
        document.getElementById('edit_leave_type').value = leave.leave_type;
        document.getElementById('edit_start_date').value = leave.start_date;
        document.getElementById('edit_end_date').value = leave.end_date;
        document.getElementById('edit_reason').value = leave.reason || '';

        new bootstrap.Modal(document.getElementById('editLeaveModal')).show();
    }

    // Edit leave form submission
    document.getElementById('editLeaveForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const leaveId = formData.get('id');
        const data = Object.fromEntries(formData);
        delete data.id;

        try {
            const response = await axios.put(`${API_BASE_URL}/leaves/${leaveId}`, data);

            showAlert('Leave request updated successfully!');
            bootstrap.Modal.getInstance(document.getElementById('editLeaveModal')).hide();
            loadLeaves();
        } catch (error) {
            console.error('Error updating leave:', error);
            showAlert('Error updating leave request', 'danger');
        }
    });

    // Approve leave
    async function approveLeave(id) {
        if (!confirm('Are you sure you want to approve this leave request?')) return;

        try {
            await axios.patch(`${API_BASE_URL}/leaves/${id}/approve`);
            showAlert('Leave request approved successfully!', 'success');
            loadLeaves();
        } catch (error) {
            console.error('Error approving leave:', error);
            showAlert('Error approving leave request', 'danger');
        }
    }

    // Reject leave
    async function rejectLeave(id) {
        if (!confirm('Are you sure you want to reject this leave request?')) return;

        try {
            await axios.patch(`${API_BASE_URL}/leaves/${id}/reject`);
            showAlert('Leave request rejected successfully!', 'warning');
            loadLeaves();
        } catch (error) {
            console.error('Error rejecting leave:', error);
            showAlert('Error rejecting leave request', 'danger');
        }
    }

    // Delete leave
    async function deleteLeave(id) {
        if (!confirm('Are you sure you want to delete this leave request?')) return;

        try {
            await axios.delete(`${API_BASE_URL}/leaves/${id}`);
            showAlert('Leave request deleted successfully!');
            loadLeaves();
        } catch (error) {
            console.error('Error deleting leave:', error);
            showAlert('Error deleting leave request', 'danger');
        }
    }
</script>
@endsection

