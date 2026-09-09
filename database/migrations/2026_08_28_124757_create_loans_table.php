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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('principal_amount', 15, 2);
            $table->decimal('interest_rate', 5, 2)->comment('Monthly interest rate (%)');
            $table->unsignedInteger('term_months');
            $table->enum('status', ['Pending', 'Approved', 'Disbursed', 'Rejected'])->default('Pending');
            $table->date('disbursement_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
