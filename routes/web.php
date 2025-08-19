<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', function () {
    //return view('welcome');
    return view('auth.login');
});

// Authentication Routes
// These routes handle user login, registration, password reset, and logout.
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'reset']);


// Protected Routes for all authenticated users
Route::middleware(['auth'])->group(function () {
    // Admin Routes (Requires 'admin' role)
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        // Add other admin routes here (e.g., user management, system reports)
    });

    // Doctor Routes (Requires 'doctor' role)
    Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::get('/patients', [DoctorController::class, 'patients'])->name('patients');
        Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
        Route::get('/medical-records/{patient}', [DoctorController::class, 'showMedicalRecord'])->name('medical.records.show');
        // Add other doctor routes here
    });

    // Nurse Routes (Requires 'nurse' role)
    Route::middleware(['role:nurse'])->prefix('nurse')->name('nurse.')->group(function () {
        Route::get('/dashboard', [NurseController::class, 'dashboard'])->name('dashboard');
        Route::get('/patients', [NurseController::class, 'patients'])->name('patients');
        Route::get('/vitals/log', [NurseController::class, 'logVitals'])->name('vitals.log');
        Route::get('/appointments', [NurseController::class, 'appointments'])->name('appointments');
        Route::get('/medication/log', [NurseController::class, 'logMedication'])->name('medication.log');
    });

    // Lab Technician Routes (Requires 'lab_technician' role)
    Route::middleware(['role:lab_technician'])->prefix('lab')->name('lab.')->group(function () {
        Route::get('/dashboard', [LabController::class, 'dashboard'])->name('dashboard');
        Route::get('/tests/pending', [LabController::class, 'pendingTests'])->name('tests.pending');
        Route::get('/tests/completed', [LabController::class, 'completedTests'])->name('tests.completed');
        Route::get('/results/upload', [LabController::class, 'uploadResults'])->name('results.upload');
        Route::get('/patients', [LabController::class, 'patientTestHistory'])->name('patients');
    });

    // Owner Routes (Requires 'owner' role)
    Route::middleware(['role:owner'])->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
        Route::get('/users/manage', [OwnerController::class, 'manageUsers'])->name('users.manage');
        Route::get('/hospitals/manage', [OwnerController::class, 'manageHospitals'])->name('hospitals.manage');
        Route::get('/reports', [OwnerController::class, 'viewReports'])->name('reports.view');
        Route::get('/settings', [OwnerController::class, 'systemSettings'])->name('settings');
    });

    // Pharmacist Routes (Requires 'pharmacist' role)
    Route::middleware(['role:pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
        Route::get('/dashboard', [PharmacistController::class, 'dashboard'])->name('dashboard');
        // Add other pharmacist routes here
    });

    // Receptionist Routes (Requires 'receptionist' role)
    Route::middleware(['role:receptionist'])->prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', [ReceptionistController::class, 'dashboard'])->name('dashboard');
        // Add other receptionist routes here
    });
});
