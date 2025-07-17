<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ManagerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /**
     * Admin Routes
     */
    Route::prefix('admin')->middleware(['role:Admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
        Route::get('/hr-dashboard', fn () => view('hr.dashboard'))->name('hr');
        Route::get('/manager-dashboard', fn () => view('manager.dashboard'))->name('manager');
        Route::get('/employee-dashboard', fn () => view('employee.dashboard'))->name('employee');

        // ✅ Admin Announcements Page
        Route::get('/announcements', [AnnouncementController::class, 'adminIndex'])
            ->name('announcements.page');
    });

    /**
     * HR Routes
     */
    Route::prefix('hr')->middleware(['role:HR'])->name('hr.')->group(function () {
        Route::get('/dashboard', fn () => view('hr.dashboard'))->name('dashboard');
    });

    /**
     * Manager Routes
     */
    Route::prefix('manager')->middleware(['role:Manager'])->name('manager.')->group(function () {
        // ✅ Now handled by ManagerController
        Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
    });

    /**
     * Employee Routes
     */
    Route::prefix('employee')->middleware(['role:Employee'])->name('employee.')->group(function () {
        Route::get('/dashboard', fn () => view('employee.dashboard'))->name('dashboard');
    });

    /**
     * Announcement API Endpoints (Create/List)
     */
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
});
