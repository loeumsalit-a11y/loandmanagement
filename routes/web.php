<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanSettingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 1. First visit -> Redirect to Dashboard if logged in, otherwise to Login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// 2. All Authenticated Routes (Protected by session auth)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Breeze Profile Management (Edit, Change Password, Delete Account)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Master Data Resources
    Route::resource('categories', CategoryController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('employees', EmployeeController::class);

    // ===== Loan Routes =====

    // Customer: ដាក់ពាក្យ
    Route::get('/loans', [LoanController::class, 'myLoans'])
        ->middleware('role:customer')->name('loans.my_loans');
    Route::get('/loans/apply', [LoanController::class, 'applyForm'])
        ->middleware('role:customer')->name('loans.apply');
    Route::post('/loans/apply', [LoanController::class, 'apply'])
        ->middleware('role:customer')->name('loans.apply.store');

    // Admin + Loan Officer + Cashier: មើលប្រាក់កម្ចីទាំងអស់
    Route::get('/loans/all', [LoanController::class, 'index'])
        ->middleware('role:admin,loan_officer,cashier')->name('loans.index');

    // Admin + Loan Officer: មើល Pending
    Route::get('/loans/pending', [LoanController::class, 'pendingList'])
        ->middleware('role:admin,loan_officer')->name('loans.pending');

    // Admin + Loan Officer: អនុម័ត
    Route::put('/loans/{loan}/approve', [LoanController::class, 'approve'])
        ->middleware('role:admin,loan_officer')->name('loans.approve');

    // Admin + Loan Officer: បើកប្រាក់
    Route::post('/loans/{loan}/disburse', [LoanController::class, 'disburse'])
        ->middleware('role:admin,loan_officer')->name('loans.disburse');

    // All roles: មើលកាលវិភាគ
    Route::get('/loans/{loan}/schedule', [LoanController::class, 'schedule'])
        ->name('loans.schedule');

    // Cashier: Form + process repayment
    Route::get('/loans/{loan}/repay', [LoanController::class, 'repayForm'])
        ->middleware('role:cashier')->name('loans.repay');
    Route::post('/loans/{loan}/repay', [LoanController::class, 'repay'])
        ->middleware('role:cashier')->name('loans.repay.store');

    // All roles: ព័ត៌មានលម្អិត
    Route::get('/loans/{loan}', [LoanController::class, 'show'])
        ->name('loans.show');

    // Admin + Loan Officer + Cashier: Overdue Dashboard
    Route::get('/dashboard/overdue', [LoanController::class, 'overdueDashboard'])
        ->middleware('role:admin,loan_officer,cashier')->name('dashboard.overdue');

    // Admin + Loan Officer: Loan Settings (interest rate)
    Route::get('/loans-settings', [LoanSettingController::class, 'edit'])
        ->middleware('role:admin,loan_officer')->name('loans.settings.edit');
    Route::put('/loans-settings', [LoanSettingController::class, 'update'])
        ->middleware('role:admin,loan_officer')->name('loans.settings.update');
});

// 3. Breeze Authentication Routes (login, register, logout, etc.)
require __DIR__.'/auth.php';
