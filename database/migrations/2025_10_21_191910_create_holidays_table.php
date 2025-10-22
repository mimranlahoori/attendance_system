<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g. "Eid-ul-Fitr", "Sunday", "Independence Day"
            $table->date('date');
            $table->enum('type', ['public', 'weekend', 'special','others'])->default('public');
            $table->boolean('is_holiday')->default(true); // Checkbox: Present or not
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
