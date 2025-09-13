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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('period_type'); // 'week', 'month', 'year'
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('avg_weight', 4, 1)->nullable();
            $table->integer('total_steps')->nullable();
            $table->integer('avg_steps')->nullable();
            $table->integer('total_calories')->nullable();
            $table->integer('avg_calories')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'period_type', 'start_date']); // 期間ごとに1レコード
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
