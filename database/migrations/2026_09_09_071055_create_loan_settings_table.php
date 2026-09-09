<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->decimal('value', 8, 2);
            $table->string('label');
            $table->timestamps();
        });

        // Seed default interest rate
        DB::table('loan_settings')->insert([
            'key'        => 'default_interest_rate',
            'value'      => 2.00,
            'label'      => 'អត្រាការប្រាក់លំនាំដើម (% / ខែ)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_settings');
    }
};
