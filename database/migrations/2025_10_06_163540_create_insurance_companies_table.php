<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    Schema::create('insurance_companies', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->string('contact_person')->nullable();
        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->text('address')->nullable();
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->timestamps();
    });

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_companies');
    }
};
