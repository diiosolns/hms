<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\NurseTriageAssessmentController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\PharmacistController;


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

Route::get('/profile/{id}', [AuthController::class, 'showProfile'])->name('profile');
Route::get('/settings', [AuthController::class, 'showAccountSettings'])->name('settings');

// Protected Routes for all authenticated users
Route::middleware(['auth'])->group(function () {

    Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
        // Dashboard Route
        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');

        // Hospital Management Routes
        Route::get('/hospitals', [OwnerController::class, 'manageHospitals'])->name('hospitals.manage');
        Route::get('/hospitals/create', [OwnerController::class, 'createHospital'])->name('hospitals.create');
        Route::post('/hospitals', [OwnerController::class, 'storeHospital'])->name('hospitals.store');
        Route::get('/hospitals/{hospital}/edit', [OwnerController::class, 'editHospital'])->name('hospitals.edit');
        Route::put('/hospitals/{hospital}', [OwnerController::class, 'updateHospital'])->name('hospitals.update');
        Route::delete('/hospitals/{hospital}', [OwnerController::class, 'destroyHospital'])->name('hospitals.destroy');

        // Branch Management Routes
        Route::get('/branches', [OwnerController::class, 'manageBranches'])->name('branches.manage');
        Route::get('/branches/create', [OwnerController::class, 'createBranch'])->name('branches.create');
        Route::post('/branches', [OwnerController::class, 'storeBranch'])->name('branches.store');
        Route::get('/branches/{branch}/edit', [OwnerController::class, 'editBranch'])->name('branches.edit');
        Route::put('/branches/{branch}', [OwnerController::class, 'updateBranch'])->name('branches.update');
        Route::delete('/branches/{branch}', [OwnerController::class, 'destroyBranch'])->name('branches.destroy');

        // Employee Management Routes
        Route::get('/employees', [OwnerController::class, 'manageEmployees'])->name('employees.manage');
        Route::get('/employees/create', [OwnerController::class, 'createEmployee'])->name('employees.create');
        Route::post('/employees', [OwnerController::class, 'storeEmployee'])->name('employees.store');
        Route::get('/employees/{user}/edit', [OwnerController::class, 'editEmployee'])->name('employees.edit');
        Route::put('/employees/{user}', [OwnerController::class, 'updateEmployee'])->name('employees.update');
        Route::delete('/employees/{user}', [OwnerController::class, 'destroyEmployee'])->name('employees.destroy');
        
        // Billing Management Routes
        Route::prefix('billing')->name('billing.')->group(function () {
            Route::get('/', [BillingController::class, 'index'])->name('index');
            Route::get('/create', [BillingController::class, 'create'])->name('create');
            Route::post('/', [BillingController::class, 'store'])->name('store');
            Route::get('/{invoice}', [BillingController::class, 'show'])->name('show');
            Route::get('/{invoice}/edit', [BillingController::class, 'edit'])->name('edit');
            Route::put('/{invoice}', [BillingController::class, 'update'])->name('update');
            Route::delete('/{invoice}', [BillingController::class, 'destroy'])->name('destroy');
        });

        // Reporting Routes
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'reportsDashboard'])->name('dashboard');
            Route::get('/hospitals', [ReportController::class, 'hospitalsReport'])->name('hospitals');
            Route::get('/employees', [ReportController::class, 'employeesReport'])->name('employees');
            Route::get('/billing', [ReportController::class, 'billingReport'])->name('billing');
            Route::get('/pharmacy', [ReportController::class, 'pharmacyReport'])->name('pharmacy');
            Route::get('/patients', [ReportController::class, 'patientsReport'])->name('patients');
        });

        //Settings
        Route::get('/settings', [OwnerController::class, 'manageHospitals'])->name('settings');
    });








    // Admin Routes (Requires 'admin' role)
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        // User Management (full CRUD)
        Route::resource('users', UserController::class);
        Route::resource('patients', PatientController::class);
        Route::resource('appointments', AppointmentController::class);

        Route::get('billing', [BillingController::class, 'index'])->name('billing.index');
        Route::get('pharmacy', [PharmacyController::class, 'index'])->name('pharmacy.index');
        Route::get('lab', [LabController::class, 'index'])->name('lab.index');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });













    // Doctor Routes (Requires 'doctor' role)
    Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::get('/patients', [PatientController::class, 'index'])->name('patients');
        Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
        Route::get('/lab-results', [DoctorController::class, 'labResults'])->name('lab_results');
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
    Route::middleware(['role:lab_technician'])->prefix('lab_technician')->name('lab_technician.')->group(function () {
        Route::get('/dashboard', [LabController::class, 'dashboard'])->name('dashboard');
        Route::get('/tests/pending', [LabController::class, 'pendingTests'])->name('tests.pending');
        Route::get('/tests/completed', [LabController::class, 'completedTests'])->name('tests.completed');
        Route::get('/results/upload', [LabController::class, 'uploadResults'])->name('results.upload');
        Route::get('/patients', [LabController::class, 'patientTestHistory'])->name('patients');
    });

    // Pharmacist Routes (Requires 'pharmacist' role)
    Route::middleware(['role:pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
        Route::get('/dashboard', [PharmacistController::class, 'dashboard'])->name('dashboard');
        Route::get('/inventory', [PharmacistController::class, 'dashboard'])->name('inventory');
        Route::get('/prescriptions', [PharmacistController::class, 'dashboard'])->name('prescriptions');
        Route::get('/billing', [PharmacistController::class, 'dashboard'])->name('billing');
    });

    // Receptionist Routes (Requires 'receptionist' role)
    Route::middleware(['role:receptionist'])->prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', [ReceptionistController::class, 'dashboard'])->name('dashboard');
        // Add other receptionist routes here
    });

    Route::prefix('nurse')->name('nurse.')->middleware(['auth', 'role:nurse'])->group(function () {
        Route::get('/dashboard', [NurseController::class, 'dashboard'])->name('dashboard');
        Route::get('/patients', [PatientController::class, 'index'])->name('patients');
        Route::get('/vitals', [PatientController::class, 'index'])->name('vitals.log');
        Route::post('/vitals', [PatientController::class, 'store'])->name('vitals.store');
        Route::get('/appointments', [NurseController::class, 'createAppointment'])->name('appointments');
        Route::post('/appointments', [NurseController::class, 'storeAppointment'])->name('appointments.store');
        Route::get('/medication', [NurseController::class, 'createMedication'])->name('medication.log');
        Route::post('/medication', [NurseController::class, 'storeMedication'])->name('medication.store');
    });

    //Can be accessed by many-users
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::patch('/patients/assign/{doctor}', [PatientController::class, 'assignDoctor'])->name('patients.assign');
    
    Route::get('/appointments/create', [ReceptionistController::class, 'createAppointments'])->name('appointments.create');
    Route::get('/appointments/', [ReceptionistController::class, 'viewAppointments'])->name('appointments.index');
    Route::get('/billing/create', [ReceptionistController::class, 'createBilling'])->name('billing.create');

    //Nurse Triage Assessments
    Route::resource('nurse-triage-assessments', NurseTriageAssessmentController::class);
    //Route::put('nurse-triage-assessments/{id}', [NurseTriageAssessmentController::class, 'update'])
    //->name('nurse-triage-assessments.update');



});
