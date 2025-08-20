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
        // New table for hospital owners
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->timestamps();
        });

        // New table for individual hospitals, linked to an owner
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('address', 255)->nullable();
            $table->timestamps();
        });

        // New table for hospital branches, linked to a hospital
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('address', 255)->nullable();
            $table->timestamps();
        });

        // 1. Modified users table to include a branch_id
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'owner', 'doctor', 'receptionist', 'pharmacist', 'lab_technician', 'nurse']);
            $table->string('phone', 15)->nullable();
            $table->string('address', 255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('date_of_birth')->nullable();
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

        // 2. Modified patients table to include a branch_id
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
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
            $table->timestamps();
        });

        // 3. Table for appointments
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('reason')->nullable();
            $table->enum('status', ['Scheduled', 'Completed', 'Cancelled'])->default('Scheduled');
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
            $table->timestamps();
        });

        // 5. Table for prescriptions
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained('medical_records')->onDelete('cascade');
            $table->string('drug_name', 100);
            $table->string('dosage', 50);
            $table->string('frequency', 50)->nullable();
            $table->string('duration', 50)->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();
        });

        // 6. Table for billing invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
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

        // New table for a predefined list of lab test names
        Schema::create('lab_test_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });

        // 8. Modified lab tests table to use a foreign key
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained('medical_records')->onDelete('cascade');
            $table->foreignId('test_catalog_id')->constrained('lab_test_catalogs')->onDelete('cascade');
            $table->enum('status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->text('results')->nullable();
            $table->string('results_file_path', 255)->nullable();
            $table->timestamps();
        });

        // 9. Table for pharmacy inventory
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->string('drug_name', 100)->unique();
            $table->integer('stock_quantity');
            $table->decimal('unit_price', 10, 2);
            $table->date('expiry_date')->nullable();
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
        Schema::dropIfExists('owners');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};