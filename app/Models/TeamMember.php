<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'position',
        'bio',
        'avatar',
        'social_links',
        'skills',
        'email',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'avatar' => 'array',
        'social_links' => 'array',
        'skills' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        // 自動生成 slug
        static::creating(function ($teamMember) {
            if (empty($teamMember->slug)) {
                $teamMember->slug = Str::slug($teamMember->name);
            }
        });

        // 刪除時清理頭像文件
        static::deleting(function ($teamMember) {
            if ($teamMember->avatar) {
                // 如果 avatar 是陣列（新格式），刪除 path
                if (is_array($teamMember->avatar) && isset($teamMember->avatar['path'])) {
                    \Storage::disk('public')->delete($teamMember->avatar['path']);
                }
                // 如果 avatar 是字串（舊格式），保持向後兼容
                elseif (is_string($teamMember->avatar)) {
                    \Storage::disk('public')->delete($teamMember->avatar);
                }
            }
        });
    }

    // 獲取頭像 URL
    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return null;
        }
        
        // 如果 avatar 是陣列（新格式），返回 url
        if (is_array($this->avatar) && isset($this->avatar['url'])) {
            return $this->avatar['url'];
        }
        
        // 如果 avatar 是字串（舊格式），保持向後兼容
        if (is_string($this->avatar)) {
            return '/storage/' . $this->avatar;
        }
        
        return null;
    }

    // 檢查是否有頭像
    public function hasAvatar()
    {
        return !empty($this->avatar);
    }

    // 獲取社交媒體連結
    public function getSocialLink($platform)
    {
        return $this->social_links[$platform] ?? null;
    }

    // 作用域：只顯示啟用的成員
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // 作用域：按排序順序排列
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
