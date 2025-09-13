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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->decimal('weight', 4, 1)->nullable(); // 体重（小数点1桁まで）
            $table->integer('steps')->nullable(); // 歩数
            $table->integer('calories')->nullable(); // カロリー
            $table->timestamps();
            $table->unique(['user_id', 'date']); // 1ユーザーにつき1日1レコード
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
