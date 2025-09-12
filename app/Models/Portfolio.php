<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'category',
        'featured_image',
        'gallery',
        'technologies',
        'project_url',
        'demo_url',
        'github_url',
        'start_date',
        'end_date',
        'team_size',
        'duration_months',
        'client_info',
        'tags',
        'sort_order',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'gallery' => 'array',
        'technologies' => 'array',
        'client_info' => 'array',
        'tags' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'team_size' => 'integer',
        'duration_months' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        // 自動生成 slug
        static::creating(function ($portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = Str::slug($portfolio->title);
            }
        });

        // 刪除時清理圖片文件
        static::deleting(function ($portfolio) {
            if ($portfolio->featured_image) {
                \Storage::disk('public')->delete($portfolio->featured_image);
            }
            
            if ($portfolio->gallery) {
                foreach ($portfolio->gallery as $image) {
                    \Storage::disk('public')->delete($image);
                }
            }
        });
    }

    // 獲取主要圖片 URL
    public function getFeaturedImageUrlAttribute()
    {
        if (!$this->featured_image) {
            return null;
        }
        return '/storage/' . $this->featured_image;
    }

    // 獲取圖片庫 URLs
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) {
            return [];
        }
        return array_map(function($image) {
            return '/storage/' . $image;
        }, $this->gallery);
    }

    // 檢查是否有主要圖片
    public function hasFeaturedImage()
    {
        return !empty($this->featured_image);
    }

    // 獲取分類顯示名稱
    public function getCategoryDisplayAttribute()
    {
        $categories = [
            'game' => '遊戲開發',
            'saas' => 'SaaS 平台',
            'web' => '網站開發',
            'mobile' => '行動應用'
        ];
        
        return $categories[$this->category] ?? $this->category;
    }

    // 獲取專案時長顯示
    public function getDurationDisplayAttribute()
    {
        if (!$this->duration_months) {
            return null;
        }
        
        if ($this->duration_months < 12) {
            return $this->duration_months . '個月';
        } else {
            $years = floor($this->duration_months / 12);
            $months = $this->duration_months % 12;
            $result = $years . '年';
            if ($months > 0) {
                $result .= $months . '個月';
            }
            return $result;
        }
    }

    // 作用域：只顯示啟用的專案
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // 作用域：精選專案
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // 作用域：按分類篩選
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // 作用域：按排序順序排列
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }
}
