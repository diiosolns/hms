<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // 1. Modified users table to include a branch_id
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->nullable()->index();
            $table->foreignId('branch_id')->nullable()->index();
            //$table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'owner', 'doctor', 'receptionist', 'pharmacist', 'lab_technician', 'nurse']);
            $table->string('phone', 15)->nullable();
            $table->string('address', 255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('room', 20)->nullable()->default('R001');
            $table->rememberToken();
            $table->timestamps();
        });

         Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // New table for individual hospitals, linked to an owner
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('contact_number', 20);
            $table->string('address', 255)->nullable();
            $table->timestamps();
        });

        // New table for hospital branches, linked to a hospital
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('contact_number', 20);
            $table->string('address', 255)->nullable();
            $table->timestamps();
        });

        // 2. Modified patients table to include a branch_id
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->nullable()->constrained('hospitals')->onDelete('set null');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('patient_id', 20)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('emergency_contact_name', 100)->nullable();
            $table->string('emergency_contact_phone', 15)->nullable();
            $table->enum('pay_method', ['Cash', 'Insurance'])->nullable()->default('Cash');
            $table->enum('status', ['Reception', 'Nurse', 'Doctor', 'Laboratory', 'Pharmacy', 'Closed', 'Discharged', 'Cancelled'])->nullable()->default('Reception');
            $table->timestamps();
        });

        // 3. Table for appointments
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null'); // NEW
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('reason')->nullable();
            $table->enum('status', ['Scheduled', 'Completed', 'Cancelled'])->default('Scheduled');
            $table->timestamps();
        });


        // 6. Table for billing invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users'); // receptionist who created invoice
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['Paid', 'Pending', 'Cancelled'])->default('Pending');
            $table->timestamps();
        });

        // 7. Table for items on an invoice
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->string('description', 255);
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('code')->unique(); // e.g., CBC001
            $table->string('name');           // e.g., Complete Blood Count
            $table->string('category')->nullable(); // Hematology, Biochemistry, etc.
            $table->text('description')->nullable();
            $table->string('sample_type')->nullable(); // Blood, Urine, etc.
            $table->string('method')->nullable();      // e.g., ELISA, PCR
            $table->string('normal_range')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });

        Schema::create('lab_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade'); // Doctor/Nurse
            $table->enum('status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('lab_request_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('lab_test_id')->constrained('lab_tests')->onDelete('cascade');
            $table->enum('status', ['Pending', 'Completed'])->default('Pending');
            $table->string('result')->nullable();
            $table->string('unit')->nullable();             // e.g., g/dL
            $table->string('reference_range')->nullable();  // e.g., 4.5–11 × 10^9/L
            $table->foreignId('performed_by')->nullable()->constrained('users')->onDelete('set null'); // Lab tech
            $table->timestamp('completed_at')->nullable();
            $table->string('attachment')->nullable(); // store file path or filename
            $table->timestamps();
        });

        Schema::create('pharmacy_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('code')->unique(); // e.g. PARA500
            $table->string('name'); // Generic name (Paracetamol)
            $table->string('brand_name')->nullable(); // Brand name (Panadol)
            $table->string('category')->nullable(); // Antibiotic, Analgesic
            $table->string('form')->nullable(); // Tablet, Syrup, Injection
            $table->string('strength')->nullable(); // 500mg, 250mg/5ml
            $table->string('unit')->default('Tablet'); // Tablet, Bottle, Vial
            $table->decimal('price', 10, 2)->default(0); // Unit price
            $table->integer('reorder_level')->default(10); // Minimum stock before alert
            $table->boolean('status')->default(true); // Active/Inactive
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });

        Schema::create('pharmacy_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->foreignId('pharmacy_item_id')->constrained('pharmacy_items')->onDelete('cascade');
            $table->enum('type', ['in', 'out', 'adjustment']); // Stock in, out, or adjustment
            $table->integer('quantity');
            $table->integer('balance')->default(0); // Running balance
            $table->string('batch_no')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('reference')->nullable(); // Purchase Order, Prescription ID
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Who made the transaction
            $table->timestamps();
        });

        // 4. Table for medical records and visit details
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->date('visit_date');
            $table->text('chief_complaint')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['Pending', 'Dispensed', 'Cancelled'])->default('Pending');
            $table->timestamps();
        });

        // 5. Table for prescriptions
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medical_record_id')->constrained('medical_records')->onDelete('cascade');
            $table->foreignId('pharmacy_items_id')->constrained('pharmacy_items')->onDelete('cascade');
            $table->string('drug_name', 100);
            $table->string('dosage', 50);
            $table->string('frequency', 50)->nullable();
            $table->string('duration', 50)->nullable();
            $table->integer('quantity'); // Total qty prescribed
            $table->integer('dispensed_qty')->default(0); // What pharmacist dispensed
            $table->text('instructions')->nullable();
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('code')->unique();   // e.g., CON_GEN, LAB_CBC
            $table->string('name');             // e.g., "General Consultation"
            $table->string('category');         // e.g., Consultation, Laboratory, Pharmacy
            $table->decimal('fee', 10, 2);      // service cost
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });

        // 10. Table for inpatient ward and bed assignments
        Schema::create('ward_and_beds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->string('ward_name', 50);
            $table->string('bed_number', 10);
            $table->enum('status', ['Occupied', 'Available', 'Maintenance'])->default('Available');
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null');
            $table->timestamps();
        });

        // 11. Modified nurse triage assessments table with columns
        Schema::create('nurse_triage_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->foreignId('nurse_id')->constrained('users')->onDelete('cascade');
            $table->decimal('body_temperature', 4, 1)->nullable();
            $table->integer('blood_pressure_systolic')->nullable();
            $table->integer('blood_pressure_diastolic')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->decimal('weight_kg', 6, 2)->nullable();
            $table->decimal('height_cm', 6, 2)->nullable();
            $table->text('chief_complaint')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['Pending', 'Updated', 'Cancelled'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order to respect foreign key constraints
        Schema::dropIfExists('lab_tests');
        Schema::dropIfExists('lab_test_catalogs');
        Schema::dropIfExists('nurse_triage_assessments');
        Schema::dropIfExists('ward_and_beds');
        Schema::dropIfExists('inventory');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('medical_records');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('users');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('hospitals');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');

/*
        Schema::dropIfExists('nurse_triage_assessments');
        Schema::dropIfExists('ward_and_beds');
        Schema::dropIfExists('services');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('medical_records');
        Schema::dropIfExists('pharmacy_stock');
        Schema::dropIfExists('pharmacy_items');
        Schema::dropIfExists('lab_request_tests');
        Schema::dropIfExists('lab_requests');
        Schema::dropIfExists('lab_tests');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('hospitals');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');*/


    }
};