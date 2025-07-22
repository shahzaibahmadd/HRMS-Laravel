# HRMS - Human Resource Management System

A modern HR platform built with **Laravel 10**, designed for managing employees, payroll, performance reviews, tasks, and company announcements.
This project supports role-based access control for **Admin**, **HR**, **Manager**, and **Employee** roles.

---

## 🚀 Features

### Authentication & Roles

* Login/Logout with Laravel's authentication.
* Role-based dashboards: Admin, HR, Manager, Employee.
* Role-specific features powered by `spatie/laravel-permission`.

### User Management

* Create, update, delete, and restore users.
* Separate views for HR, Manager, and Employee lists.
* Profile and role management.

### Announcements

* Admin can create and manage announcements.
* Announcements displayed on dashboards (HR, Manager, Employee).

### Payroll Management

* View, edit, and update payrolls for employees.
* Payslip generation and download (PDF).
* Role-based payroll access (Admin, HR, Manager).

### Performance Reviews

* Create, edit, and delete performance reviews.
* Role-based access to reviews.
* Send performance review emails to employees via the **Send Review** button (Mail).

### Task Management

* Task creation (Admin, HR, Manager).
* Task assignment and completion tracking.
* Employees can mark tasks as completed.

### Email Notifications

* Email reminders for performance reviews using **Mailable** (`PerformanceReviewMail`).
* Ready for queue integration for background email sending.

---

## 🛠️ Tech Stack

* **Framework:** Laravel 10
* **Database:** MySQL
* **Authentication:** Laravel Breeze / Custom Login (with roles)
* **Mailing:** Laravel Mailables
* **Styling:** Blade Templates, Bootstrap 5
* **Permissions:** spatie/laravel-permission
* **PDF Generation:** (optional) dompdf or snappy for payslip downloads
* **Other:** Carbon for date handling

---

## ⚙️ Installation

### 1. Clone Repository

```bash
git clone <repo-url>
cd HRMS
```
