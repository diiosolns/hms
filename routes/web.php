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
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PharmacyItemController;
use App\Http\Controllers\PharmacyStockController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\InvoiceController;

use App\Http\Controllers\AssetMaintenanceController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\InsuranceCompanyController;



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
Route::get('/profile/{id}/settings', [AuthController::class, 'showAccountSettings'])->name('profile.settings');
Route::post('/user/password/update', [AuthController::class, 'updatePassword'])->name('user.password.update');
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
        
        // Employee Management Routes
        Route::get('/employees', [AdminController::class, 'manageEmployees'])->name('employees.manage');
        Route::get('/employees/create', [AdminController::class, 'createEmployee'])->name('employees.create');
        Route::post('/employees', [AdminController::class, 'storeEmployee'])->name('employees.store');
        Route::get('/employees/{user}/edit', [AdminController::class, 'editEmployee'])->name('employees.edit');
        Route::put('/employees/{user}', [AdminController::class, 'updateEmployee'])->name('employees.update');
        Route::delete('/employees/{user}', [AdminController::class, 'destroyEmployee'])->name('employees.destroy');
        
        Route::resource('lab', LabTestController::class);
        Route::resource('pharmacy', PharmacyItemController::class);
        Route::resource('appointments', AppointmentController::class);
        // User Management (full CRUD)
        //Route::resource('users', UserController::class);
        Route::resource('patients', PatientController::class);
        Route::resource('appointments', AppointmentController::class);
        Route::resource('services', ServiceController::class);

        Route::get('billing', [BillingController::class, 'index'])->name('billing.index');
        //Route::get('pharmacy', [PharmacyController::class, 'index'])->name('pharmacy.index');
        //Route::get('lab', [LabController::class, 'index'])->name('lab.index');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });







    // Doctor Routes (Requires 'doctor' role)
    Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::get('/patients', [DoctorController::class, 'patients'])->name('patients');
        Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
        Route::get('/reports', [DoctorController::class, 'reports'])->name('reports');
        
        // Updates via modals
        Route::post('/medical-records/{patient}/diagnosis', [DoctorController::class, 'updateDiagnosis'])->name('medical-records.updateDiagnosis');
        Route::post('/medical-records/{patient}/lab-tests', [DoctorController::class, 'storeLabTests'])->name('lab-tests.store');
        Route::post('/medical-records/{patient}/prescriptions', [DoctorController::class, 'storePrescriptions'])->name('prescriptions.store');

        //Remove prescription or lab test
        Route::delete('/medical-records/{patient}/prescriptions/{prescription}', [DoctorController::class, 'removePrescription'])->name('prescriptions.removeItem');
        Route::delete('/medical-records/{patient}/lab-tests/{labRequestTest}', [DoctorController::class, 'removeLabTest'])->name('labtests.removeItem');

        Route::get('/patients/direct-reception/{id}', [PatientController::class, 'directReception'])->name('patients.direct.reception');

        //Search
        Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');

    });





    

    // Nurse Routes (Requires 'nurse' role)
    Route::middleware(['role:nurse'])->prefix('nurse')->name('nurse.')->group(function () {
        Route::get('/dashboard', [NurseController::class, 'dashboard'])->name('dashboard');
        //Route::get('/patients', [NurseController::class, 'patients'])->name('patients');
        Route::get('/patients', [PatientController::class, 'index'])->name('patients');
        Route::get('/vitals/log', [NurseController::class, 'logVitals'])->name('vitals.log');
        Route::get('/appointments', [NurseController::class, 'appointments'])->name('appointments');
        Route::get('/reports', [NurseController::class, 'reports'])->name('reports');
        Route::get('/medication/log', [NurseController::class, 'logMedication'])->name('medication.log');
    });

    // Lab Technician Routes (Requires 'lab_technician' role)
    Route::middleware(['role:lab_technician'])->prefix('lab_technician')->name('lab_technician.')->group(function () {
        Route::get('/dashboard', [LabController::class, 'dashboard'])->name('dashboard');
        Route::get('/tests/pending', [LabController::class, 'pendingTests'])->name('tests.pending');
        Route::post('/results/upload/{id}', [LabController::class, 'uploadResults'])->name('results.upload');
        Route::get('/patients', [LabController::class, 'patientTestHistory'])->name('patients');
        Route::get('/reports', [LabController::class, 'reports'])->name('reports.index');
        Route::get('/appointments', [LabController::class, 'appointments'])->name('appointments.index');

        //Update Lab request test
        Route::get('/labtests/requests', [LabController::class, 'labTestsRequest'])->name('labtests.requests');
        Route::get('/labtests/completed', [LabController::class, 'labTestsRequestCompleted'])->name('labtests.completed');
        Route::get('/labtests/results', [LabController::class, 'labTestsRequest'])->name('labtests.upload');
        Route::get('/labtests/patients', [LabController::class, 'labTestsPatients'])->name('patients');
        Route::get('/labtests/requests/{id}', [LabController::class, 'showRequest'])->name('labtests.requests.show');
        Route::get('/labtests', [LabController::class, 'labTestsCatalog'])->name('catalog');
        Route::get('/labtests/{id}', [LabController::class, 'showCatalogItem'])->name('catalog.show');
        Route::post('/medical-records/{id}/labtests', [LabController::class, 'updateTestItem'])->name('medical-records.updateTestItem');
        Route::get('/labtests/patient-doctor/{id}', [LabController::class, 'sendBackToDoctor'])->name('patient.back.doctor');
        Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');

    });

    // Pharmacist Routes (Requires 'pharmacist' role)
    Route::middleware(['role:pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
        Route::get('/dashboard', [PharmacistController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/pharmacy/items', [PharmacyItemController::class, 'index'])->name('items.index');
        Route::get('/pharmacy/item/create', [PharmacyItemController::class, 'create'])->name('items.create');
        Route::get('/pharmacy/stock/index', [PharmacyStockController::class, 'index'])->name('stock.index');
        Route::get('/pharmacy/stock/create', [PharmacyStockController::class, 'create'])->name('stock.create');
        Route::get('/pharmacy/stock/edit/{id}', [PharmacyStockController::class, 'edit'])->name('stock.edit');
        Route::get('/pharmacy/stock/destroy/{id}', [PharmacyStockController::class, 'destroy'])->name('stock.destroy');
        Route::get('/pharmacy/stock/adjustments', [PharmacyStockController::class, 'create'])->name('stock.adjustments');
        Route::post('/pharmacy/stock/storeMultiple', [PharmacyStockController::class, 'storeMultiple'])->name('stock.storeMultiple');

        Route::get('/prescriptions', [PharmacistController::class, 'prescriptions'])->name('prescriptions');
        Route::get('/billing', [PharmacistController::class, 'dashboard'])->name('billing');

        //Update prescriptions
        Route::post('/medical-records/{patient}/prescriptions', [PharmacistController::class, 'updateDispense'])->name('medical-records.updateDispense');
        //search
        Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');

        //Reports
        Route::get('/pharmacy/reports/stock', [PharmacistController::class, 'dashboard'])->name('reports.stock');
        Route::get('/pharmacy/reports/profit', [PharmacistController::class, 'dashboard'])->name('reports.profit');
        Route::get('/pharmacy/reports/expiry', [PharmacistController::class, 'dashboard'])->name('reports.expiry');
        
    });












    // Receptionist Routes (Requires 'receptionist' role)
    Route::middleware(['role:receptionist'])->prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', [ReceptionistController::class, 'dashboard'])->name('dashboard');
        Route::get('/billing', [ReceptionistController::class, 'billing'])->name('billing.index');
        Route::get('/reports', [ReceptionistController::class, 'reports'])->name('reports.index');
        Route::resource('appointments', AppointmentController::class);
        // Add other receptionist routes here
        //Search
        Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');
    });

    /*Route::prefix('nurse')->name('nurse.')->middleware(['auth', 'role:nurse'])->group(function () {
        Route::get('/dashboard', [NurseController::class, 'dashboard'])->name('dashboard');
        Route::get('/patients', [PatientController::class, 'index'])->name('patients');
        Route::get('/vitals', [PatientController::class, 'index'])->name('vitals.log');
        Route::post('/vitals', [PatientController::class, 'store'])->name('vitals.store');
        Route::get('/appointments', [NurseController::class, 'createAppointment'])->name('appointments');
        Route::post('/appointments', [NurseController::class, 'storeAppointment'])->name('appointments.store');
        Route::get('/medication', [NurseController::class, 'createMedication'])->name('medication.log');
        Route::post('/medication', [NurseController::class, 'storeMedication'])->name('medication.store');
    });*/

    //Can be accessed by many-users
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');
    Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::patch('/patients/assign/{doctor}', [PatientController::class, 'assignDoctor'])->name('patients.assign');
    Route::get('/patients/direct-lab/{id}', [PatientController::class, 'directLab'])->name('patients.direct.lab');
    Route::get('/patients/direct-pharmacy/{id}', [PatientController::class, 'directPharmacy'])->name('patients.direct.pharmacy');
    Route::get('/patients/direct-reception/{id}', [PatientController::class, 'directReception'])->name('patients.direct.reception');
    Route::put('/patients/{id}/status', [PatientController::class, 'updateStatus'])->name('patients.updateStatus');
    Route::resource('appointments', AppointmentController::class);
    Route::delete('/patients/{patient}/prescriptions/{prescription}', [DoctorController::class, 'removePrescription'])->name('prescriptions.removeItem');
    Route::resource('pharmacy', PharmacyItemController::class);
    
    //Route::get('/appointments/create', [ReceptionistController::class, 'createAppointments'])->name('appointments.create');
    //Route::get('/appointments/', [ReceptionistController::class, 'viewAppointments'])->name('appointments.index');
    Route::resource('appointments', AppointmentController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::delete('{invoice}/remove-item/{item}', [InvoiceController::class, 'removeItem'])->name('removeItem');
        Route::post('{invoice}/clear-bill', [InvoiceController::class, 'clearBill'])->name('clearBill');
        Route::post('{invoice}/cancel', [InvoiceController::class, 'cancel'])->name('cancel');
    });
    
    Route::get('/billing/create', [ReceptionistController::class, 'createBilling'])->name('billing.create');

    //Nurse Triage Assessments
    Route::resource('nurse-triage-assessments', NurseTriageAssessmentController::class);
    //Route::put('nurse-triage-assessments/{id}', [NurseTriageAssessmentController::class, 'update'])
    //->name('nurse-triage-assessments.update');




    //Manage insurance companies
    Route::resource('insurance_companies', InsuranceCompanyController::class);


});


Route::middleware(['auth'])->prefix('assets')->name('assets.')->group(function () {
    Route::resource('categories', AssetCategoryController::class);
    Route::resource('asset', AssetController::class);
    //Route::resource('/', AssetController::class)->parameters(['' => 'asset']);
    //Route::get('{asset}/maintenances', [AssetMaintenanceController::class, 'create'])->name('maintenances.create');
    Route::get('{asset}/maintenances', [AssetMaintenanceController::class, 'index'])->name('maintenances.index');
    Route::get('{asset}/maintenances/create', [AssetMaintenanceController::class, 'create'])->name('maintenances.create');
    Route::post('{asset}/maintenances', [AssetMaintenanceController::class, 'store'])->name('maintenances.store');
    Route::get('{asset}/maintenances/{maintenance}/show', [AssetMaintenanceController::class, 'show'])->name('maintenances.show');
    Route::get('{asset}/maintenances/{maintenance}/edit', [AssetMaintenanceController::class, 'edit'])->name('maintenances.edit');
    Route::put('{asset}/maintenances/{maintenance}', [AssetMaintenanceController::class, 'update'])->name('maintenances.update');
    Route::delete('{asset}/maintenances/{maintenance}', [AssetMaintenanceController::class, 'destroy'])->name('maintenances.destroy');
});
