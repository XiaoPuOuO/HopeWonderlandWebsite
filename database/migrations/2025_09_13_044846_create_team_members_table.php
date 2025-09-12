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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 姓名
            $table->string('slug')->unique(); // URL 友好的名稱
            $table->string('position'); // 職位
            $table->text('bio')->nullable(); // 個人簡介
            $table->string('avatar')->nullable(); // 頭像
            $table->json('social_links')->nullable(); // 社交媒體連結
            $table->json('skills')->nullable(); // 技能標籤
            $table->string('email')->nullable(); // 聯絡信箱
            $table->integer('sort_order')->default(0); // 排序
            $table->boolean('is_active')->default(true); // 是否啟用
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
