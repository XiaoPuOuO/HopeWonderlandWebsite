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
        Schema::create('sub_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 子品牌名稱
            $table->string('slug')->unique(); // URL 友好的標識符
            $table->text('description')->nullable(); // 子品牌描述
            $table->string('logo')->nullable(); // 子品牌 Logo 路徑
            $table->string('website_url')->nullable(); // 子品牌官網連結
            $table->string('color_primary')->default('#6366f1'); // 主要色彩
            $table->string('color_secondary')->nullable(); // 次要色彩
            $table->json('tags')->nullable(); // 標籤（JSON 格式）
            $table->boolean('is_active')->default(true); // 是否啟用
            $table->integer('sort_order')->default(0); // 排序順序
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_brands');
    }
};
