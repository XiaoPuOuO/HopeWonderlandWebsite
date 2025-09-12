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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // 專案標題
            $table->string('slug')->unique(); // URL 友好的標題
            $table->text('description'); // 專案描述
            $table->text('content')->nullable(); // 詳細內容
            $table->string('category'); // 分類 (game, saas, web, mobile)
            $table->string('featured_image')->nullable(); // 主要圖片
            $table->json('gallery')->nullable(); // 圖片庫
            $table->json('technologies')->nullable(); // 使用的技術
            $table->string('project_url')->nullable(); // 專案連結
            $table->string('demo_url')->nullable(); // 示範連結
            $table->string('github_url')->nullable(); // GitHub 連結
            $table->date('start_date')->nullable(); // 開始日期
            $table->date('end_date')->nullable(); // 結束日期
            $table->integer('team_size')->nullable(); // 團隊人數
            $table->integer('duration_months')->nullable(); // 開發時長（月）
            $table->json('client_info')->nullable(); // 客戶資訊
            $table->json('tags')->nullable(); // 標籤
            $table->integer('sort_order')->default(0); // 排序
            $table->boolean('is_featured')->default(false); // 是否精選
            $table->boolean('is_active')->default(true); // 是否啟用
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
