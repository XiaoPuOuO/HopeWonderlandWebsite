<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'company',
        'phone',
        'service',
        'budget',
        'timeline',
        'message',
        'source',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // 服務類型選項
    public static function getServiceOptions()
    {
        return [
            'game-development' => '遊戲開發',
            'saas-development' => 'SaaS 平台開發',
            'web-development' => '網站開發',
            'mobile-development' => '行動應用開發',
            'outsourcing' => '代工服務',
            'consulting' => '技術諮詢',
            'other' => '其他',
        ];
    }

    // 預算範圍選項
    public static function getBudgetOptions()
    {
        return [
            'under-50k' => '50萬以下',
            '50k-100k' => '50-100萬',
            '100k-200k' => '100-200萬',
            '200k-500k' => '200-500萬',
            'over-500k' => '500萬以上',
            'discuss' => '面議',
        ];
    }

    // 專案時程選項
    public static function getTimelineOptions()
    {
        return [
            'urgent' => '緊急（1個月內）',
            'fast' => '快速（1-3個月）',
            'normal' => '正常（3-6個月）',
            'flexible' => '彈性（6個月以上）',
        ];
    }

    // 來源選項
    public static function getSourceOptions()
    {
        return [
            'contact' => '聯絡我們頁面',
            'home' => '首頁',
        ];
    }

    // 獲取服務類型顯示名稱
    public function getServiceDisplayAttribute()
    {
        return self::getServiceOptions()[$this->service] ?? $this->service;
    }

    // 獲取預算範圍顯示名稱
    public function getBudgetDisplayAttribute()
    {
        return self::getBudgetOptions()[$this->budget] ?? $this->budget;
    }

    // 獲取專案時程顯示名稱
    public function getTimelineDisplayAttribute()
    {
        return self::getTimelineOptions()[$this->timeline] ?? $this->timeline;
    }

    // 獲取來源顯示名稱
    public function getSourceDisplayAttribute()
    {
        return self::getSourceOptions()[$this->source] ?? $this->source;
    }

    // 標記為已讀
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    // 標記為未讀
    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }
}
