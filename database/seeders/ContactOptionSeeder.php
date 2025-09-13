<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactOption;

class ContactOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 服務類型選項
        $serviceOptions = [
            ['value' => 'web-development', 'label' => '網站開發', 'sort_order' => 1],
            ['value' => 'mobile-app', 'label' => '手機應用程式開發', 'sort_order' => 2],
            ['value' => 'ui-ux-design', 'label' => 'UI/UX 設計', 'sort_order' => 3],
            ['value' => 'branding', 'label' => '品牌設計', 'sort_order' => 4],
            ['value' => 'digital-marketing', 'label' => '數位行銷', 'sort_order' => 5],
            ['value' => 'ecommerce', 'label' => '電商平台開發', 'sort_order' => 6],
            ['value' => 'consultation', 'label' => '技術諮詢', 'sort_order' => 7],
            ['value' => 'maintenance', 'label' => '網站維護', 'sort_order' => 8],
            ['value' => 'other', 'label' => '其他', 'sort_order' => 9],
        ];

        foreach ($serviceOptions as $option) {
            ContactOption::create([
                'type' => 'service',
                'value' => $option['value'],
                'label' => $option['label'],
                'sort_order' => $option['sort_order'],
                'is_active' => true
            ]);
        }

        // 預算範圍選項
        $budgetOptions = [
            ['value' => 'under-50k', 'label' => '50萬以下', 'sort_order' => 1],
            ['value' => '50k-100k', 'label' => '50萬 - 100萬', 'sort_order' => 2],
            ['value' => '100k-200k', 'label' => '100萬 - 200萬', 'sort_order' => 3],
            ['value' => '200k-500k', 'label' => '200萬 - 500萬', 'sort_order' => 4],
            ['value' => '500k-1m', 'label' => '500萬 - 1000萬', 'sort_order' => 5],
            ['value' => 'over-1m', 'label' => '1000萬以上', 'sort_order' => 6],
            ['value' => 'discuss', 'label' => '需要討論', 'sort_order' => 7],
        ];

        foreach ($budgetOptions as $option) {
            ContactOption::create([
                'type' => 'budget',
                'value' => $option['value'],
                'label' => $option['label'],
                'sort_order' => $option['sort_order'],
                'is_active' => true
            ]);
        }
    }
}
