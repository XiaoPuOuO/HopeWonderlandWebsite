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
        Schema::create('contact_options', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'service' 或 'budget'
            $table->string('value'); // 選項值
            $table->string('label'); // 顯示標籤
            $table->integer('sort_order')->default(0); // 排序順序
            $table->boolean('is_active')->default(true); // 是否啟用
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->unique(['type', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_options');
    }
};
