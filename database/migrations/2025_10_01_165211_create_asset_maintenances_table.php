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
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');

            $table->date('maintenance_date');
            $table->string('performed_by')->nullable(); // internal staff or vendor
            $table->text('details')->nullable();
            $table->decimal('cost', 12, 2)->nullable();
            $table->date('next_due_date')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_maintenances');
    }
};
