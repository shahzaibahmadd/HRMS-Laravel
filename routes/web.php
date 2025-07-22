    <?php

    use App\Http\Controllers\Admin\UserManagementController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\Payroll\PayrollController;
    use App\Http\Controllers\Payslip\PayslipController;
    use App\Http\Controllers\PerformanceReview\PerformanceReviewController;
    use App\Http\Controllers\AnnouncementController;
    use App\Http\Controllers\ManagerController;
    use App\Http\Controllers\Task\TaskController;
    use App\Models\Announcement;
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


        Route::prefix('admin')->middleware(['role:Admin'])->name('admin.')->group(function () {


            Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
            Route::get('/hr-dashboard', fn () => view('hr.dashboard'))->name('hr');
            Route::get('/manager-dashboard', fn () => view('manager.dashboard'))->name('manager');
            Route::get('/employee-dashboard', fn () => view('employee.dashboard'))->name('employee');


            Route::get('/announcements', [AnnouncementController::class, 'adminIndex'])
                ->name('announcements.page');



            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/create', [UserManagementController::class, 'store'])->name('users.store');



            Route::get('/users/hr',[UserManagementController::class,'listHR'])->name('users.hr');
            Route::get('/users/manager',[UserManagementController::class,'listManagers'])->name('users.manager');
            Route::get('/users/employee',[UserManagementController::class,'listEmployees'])->name('users.employee');

            Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
            Route::post('/users/{user}/restore', [UserManagementController::class, 'restore'])->name('users.restore');


            Route::get('users/{user}/profile',[UserManagementController::class,'profile'])->name('users.profile');
            Route::get('/users/{user}/dashboard',[UserManagementController::class,'dashboardRedirect'])->name('users.dashboard');



        });




        Route::prefix('hr')->middleware(['role:HR'])->name('hr.')->group(function () {

            Route::get('/dashboard',function (){
                $user=auth()->user();
                $announcements = Announcement::where('is_active', 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
                return view('hr.dashboard',compact('user','announcements'));

            })->name('dashboard');
        });


        Route::prefix('manager')->middleware(['role:Manager'])->name('manager.')->group(function () {

            Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
        });


        Route::prefix('employee')->middleware(['role:Employee'])->name('employee.')->group(function () {


            Route::get('/dashboard', function () {
                $user = auth()->user();
                $announcements = Announcement::where('is_active', 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
                return view('employee.dashboard', compact('user','announcements'));
            })->name('dashboard');
        });


        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');



    //    payroll routes


        Route::prefix('payroll')->name('payroll.')->group(function () {

            Route::get('/{user}', [PayrollController::class, 'show'])
                ->middleware('role')
                ->name('show');

            Route::middleware(['role:Admin'])->group(function () {
                Route::get('/admin/{user}/edit', [PayrollController::class, 'edit'])->name('admin.edit');
                Route::put('/admin/{user}', [PayrollController::class, 'update'])->name('admin.update');
            });




            Route::middleware(['role:HR'])->group(function () {
                Route::get('/hr/{user}/edit', [PayrollController::class, 'edit'])->name('hr.edit');
                Route::put('/hr/{user}', [PayrollController::class, 'update'])->name('hr.update');
            });


            Route::middleware(['role:Manager'])->group(function () {
                Route::get('/manager/{user}/edit', [PayrollController::class, 'edit'])->name('manager.edit');
                Route::put('/manager/{user}', [PayrollController::class, 'update'])->name('manager.update');
            });

        });

        Route::prefix('payslips')->name('payslips.')->middleware(['auth'])->group(function () {


            Route::post('/generate/{payroll}', [PayslipController::class, 'generate'])
                ->name('generate');


            Route::get('/download/{payslip}', [PayslipController::class, 'download'])
                ->name('download');
        });



        Route::prefix('tasks')->name('tasks.')->group(function () {

            // All authenticated users can view their assigned tasks
            Route::get('/', [TaskController::class, 'index'])->name('index');

            // Only assigned users can mark their task as completed
            Route::post('/{task}/complete', [TaskController::class, 'markAsCompleted'])
                ->whereNumber('task')
                ->name('markAsCompleted');

            // Task creation - Admin, HR, Manager
            Route::middleware('role:Admin|HR|Manager')->group(function () {
                Route::get('/create', [TaskController::class, 'create'])->name('create');
                Route::post('/', [TaskController::class, 'store'])->name('store');
            });

            // View a single task (after /create to avoid 404)
            Route::get('/{task}', [TaskController::class, 'show'])
                ->whereNumber('task')
                ->name('show');

            // Edit, update, delete - Admin, HR, Manager (if assigned_by = auth user)
            Route::middleware('role:Admin|HR|Manager')->group(function () {
                Route::get('/{task}/edit', [TaskController::class, 'edit'])
                    ->whereNumber('task')
                    ->name('edit');
                Route::put('/{task}', [TaskController::class, 'update'])
                    ->whereNumber('task')
                    ->name('update');
                Route::delete('/{task}', [TaskController::class, 'destroy'])
                    ->whereNumber('task')
                    ->name('destroy');
            });
         });




        Route::prefix('performance-reviews')->name('performance.')->group(function () {


            Route::get('/', [PerformanceReviewController::class, 'index'])->name('index');


            Route::get('/{review}', [PerformanceReviewController::class, 'show'])
                ->whereNumber('review')
                ->name('show');


            Route::middleware(['role:Admin|HR|Manager'])->group(function () {
                Route::get('/create', [PerformanceReviewController::class, 'create'])->name('create');
                Route::post('/', [PerformanceReviewController::class, 'store'])->name('store');
            });


            Route::middleware(['role:Admin|HR|Manager'])->group(function () {
                Route::get('/{review}/edit', [PerformanceReviewController::class, 'edit'])
                    ->whereNumber('review')
                    ->name('edit');
                Route::put('/{review}', [PerformanceReviewController::class, 'update'])
                    ->whereNumber('review')
                    ->name('update');
            });


            Route::middleware(['role:Admin'])->group(function () {
                Route::delete('/{review}', [PerformanceReviewController::class, 'destroy'])
                    ->whereNumber('review')
                    ->name('destroy');
            });


            Route::middleware(['role:Admin|HR'])->post('/send-reminders', [PerformanceReviewController::class, 'sendReminders'])
                ->name('sendReminders');
        });


    });
