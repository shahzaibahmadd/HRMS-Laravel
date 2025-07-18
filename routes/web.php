<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes (role: Admin)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware(['role:Admin'])->name('admin.')->group(function () {

        // Core dashboards (as in original file)
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
        Route::get('/hr-dashboard', fn () => view('hr.dashboard'))->name('hr');
        Route::get('/manager-dashboard', fn () => view('manager.dashboard'))->name('manager');
        Route::get('/employee-dashboard', fn () => view('employee.dashboard'))->name('employee');

        // ✅ Admin Announcements Page
        Route::get('/announcements', [AnnouncementController::class, 'adminIndex'])
            ->name('announcements.page');

        /*
        |--------------------------------------------------------------------------
        | User Management (missing in your version, added now)
        |--------------------------------------------------------------------------
        */
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/create', [UserManagementController::class, 'store'])->name('users.store');



        Route::get('/users/hr',[UserManagementController::class,'listHR'])->name('users.hr');
        Route::get('/users/manager',[UserManagementController::class,'listManagers'])->name('users.manager');
        Route::get('/users/employee',[UserManagementController::class,'listEmployees'])->name('users.employee');

        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');

        Route::get('users/{user}/profile',[UserManagementController::class,'profile'])->name('users.profile');
        Route::get('/users/{user}/dashboard',[UserManagementController::class,'dashboardRedirect'])->name('users.dashboard');




    });



    });

    /*
    |--------------------------------------------------------------------------
    | HR Routes (role: HR)
    |--------------------------------------------------------------------------
    */
    Route::prefix('hr')->middleware(['role:HR'])->name('hr.')->group(function () {

        Route::get('/dashboard',function (){
            $user=auth()->user();
            return view('hr.dashboard',compact('user'));

        })->name('dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | Manager Routes (role: Manager)
    |--------------------------------------------------------------------------
    */
    Route::prefix('manager')->middleware(['role:Manager'])->name('manager.')->group(function () {

        Route::get('/dashboard', function (){
            $user=auth()->user();
            return view('manager.dashboard',compact('user'));
        })->name('dashboard');
=======
    

    });

    /*
    |--------------------------------------------------------------------------
    | Employee Routes (role: Employee)
    |--------------------------------------------------------------------------
    */
    Route::prefix('employee')->middleware(['role:Employee'])->name('employee.')->group(function () {

    




=======
        Route::get('/dashboard', function () {
            $user = auth()->user();
            return view('employee.dashboard', compact('user'));
        })->name('dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | Announcement API Endpoints (global)
    |--------------------------------------------------------------------------
    | These power AJAX creates + page loads (admin & manager).
    */
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');

});
