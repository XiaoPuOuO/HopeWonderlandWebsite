<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'value',
        'label',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // 獲取所有服務類型選項
    public static function getServiceOptions()
    {
        return self::where('type', 'service')
                   ->where('is_active', true)
                   ->orderBy('sort_order')
                   ->pluck('label', 'value')
                   ->toArray();
    }

    // 獲取所有預算範圍選項
    public static function getBudgetOptions()
    {
        return self::where('type', 'budget')
                   ->where('is_active', true)
                   ->orderBy('sort_order')
                   ->pluck('label', 'value')
                   ->toArray();
    }

    // 獲取指定類型的選項
    public static function getOptionsByType($type)
    {
        return self::where('type', $type)
                   ->where('is_active', true)
                   ->orderBy('sort_order')
                   ->get();
    }
}
