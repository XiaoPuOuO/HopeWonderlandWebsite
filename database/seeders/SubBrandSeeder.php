<?php

namespace Database\Seeders;

use App\Models\SubBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subBrands = [
            [
                'name' => 'GameForge Studio',
                'slug' => 'gameforge-studio',
                'description' => '專業遊戲開發工作室，專精於多人線上遊戲和單機遊戲開發，提供從概念設計到上線運營的完整解決方案。',
                'logo' => null,
                'website_url' => 'https://gameforge.example.com',
                'color_primary' => '#ff6b6b',
                'color_secondary' => '#ff8e8e',
                'tags' => ['遊戲開發', '多人遊戲', '單機遊戲', '遊戲代工'],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'CloudTech Solutions',
                'slug' => 'cloudtech-solutions',
                'description' => '企業級 SaaS 平台開發專家，專精於微服務架構、雲端部署和 API 開發，為企業提供可擴展的數位解決方案。',
                'logo' => null,
                'website_url' => 'https://cloudtech.example.com',
                'color_primary' => '#4ecdc4',
                'color_secondary' => '#6ed5ce',
                'tags' => ['SaaS開發', '微服務', '雲端部署', 'API開發'],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'DevCraft Agency',
                'slug' => 'devcraft-agency',
                'description' => '專業代工開發服務，提供網站代工、應用程式開發、系統整合和技術諮詢，協助客戶實現技術願景。',
                'logo' => null,
                'website_url' => 'https://devcraft.example.com',
                'color_primary' => '#45b7d1',
                'color_secondary' => '#6bc5d8',
                'tags' => ['代工服務', '網站開發', '系統整合', '技術諮詢'],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'DataFlow Analytics',
                'slug' => 'dataflow-analytics',
                'description' => '數據分析與商業智能平台，提供大數據處理、機器學習模型和商業洞察分析服務。',
                'logo' => null,
                'website_url' => 'https://dataflow.example.com',
                'color_primary' => '#96ceb4',
                'color_secondary' => '#a8d5c1',
                'tags' => ['數據分析', '機器學習', '商業智能', '大數據'],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'SecureNet Systems',
                'slug' => 'securenet-systems',
                'description' => '網路安全與系統防護專家，提供企業級安全解決方案、滲透測試和安全諮詢服務。',
                'logo' => null,
                'website_url' => 'https://securenet.example.com',
                'color_primary' => '#feca57',
                'color_secondary' => '#fed976',
                'tags' => ['網路安全', '系統防護', '滲透測試', '安全諮詢'],
                'is_active' => false,
                'sort_order' => 5,
            ],
        ];

        foreach ($subBrands as $subBrandData) {
            SubBrand::create($subBrandData);
        }
    }
}
