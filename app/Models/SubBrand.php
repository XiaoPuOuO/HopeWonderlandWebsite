<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class SubBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'website_url',
        'color_primary',
        'color_secondary',
        'tags',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * 自動生成 slug 和處理圖片刪除
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($subBrand) {
            if (empty($subBrand->slug)) {
                $subBrand->slug = Str::slug($subBrand->name);
            }
        });
        
        // 刪除時自動清理圖片文件
        static::deleting(function ($subBrand) {
            if ($subBrand->logo) {
                $imageService = app(ImageService::class);
                $imageService->deleteImage($subBrand->logo);
            }
        });
    }

    /**
     * 獲取啟用的子品牌
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 按排序順序排列
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * 獲取 Logo 的完整 URL
     */
    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        
        // 確保返回的是完整的 URL 路徑
        return '/storage/' . ltrim($this->logo, '/');
    }

    /**
     * 獲取 Logo 的縮略圖 URL
     */
    public function getLogoThumbnailUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        
        $pathInfo = pathinfo($this->logo);
        $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
        
        if (Storage::disk('public')->exists($thumbnailPath)) {
            return Storage::disk('public')->url($thumbnailPath);
        }
        
        return $this->logo_url;
    }

    /**
     * 檢查是否有 Logo
     */
    public function hasLogo()
    {
        return !empty($this->logo) && Storage::disk('public')->exists($this->logo);
    }
}
