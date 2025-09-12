<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected $manager;
    protected $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp'
    ];
    
    protected $maxFileSize = 5 * 1024 * 1024; // 5MB
    protected $maxDimensions = 2048; // 最大尺寸

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * 安全處理上傳的圖片
     */
    public function processUploadedImage(UploadedFile $file, string $directory = 'brands'): array
    {
        // 驗證文件
        $this->validateFile($file);
        
        // 生成唯一文件名
        $filename = $this->generateUniqueFilename($file);
        $path = $directory . '/' . $filename;
        
        // 讀取並重塑圖片
        $image = $this->manager->read($file->getPathname());
        
        // 獲取原始尺寸
        $originalWidth = $image->width();
        $originalHeight = $image->height();
        
        // 計算新尺寸（保持比例）
        $newDimensions = $this->calculateNewDimensions($originalWidth, $originalHeight);
        
        // 重塑圖片
        $image->resize($newDimensions['width'], $newDimensions['height']);
        
        // 轉換為安全的格式（JPEG）
        $processedImage = $image->toJpeg(90); // 90% 質量
        
        // 保存到存儲
        Storage::disk('public')->put($path, $processedImage);
        
        // 生成 URL
        $url = '/storage/' . $path;
        
        return [
            'success' => true,
            'filename' => $filename,
            'path' => $path,
            'url' => $url,
            'original_size' => [
                'width' => $originalWidth,
                'height' => $originalHeight
            ],
            'processed_size' => [
                'width' => $newDimensions['width'],
                'height' => $newDimensions['height']
            ],
            'file_size' => strlen($processedImage)
        ];
    }

    /**
     * 驗證上傳的文件
     */
    protected function validateFile(UploadedFile $file): void
    {
        // 檢查 MIME 類型
        if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
            throw new \InvalidArgumentException('不支援的圖片格式。僅支援 JPEG、PNG、GIF、WebP 格式。');
        }
        
        // 檢查文件大小
        if ($file->getSize() > $this->maxFileSize) {
            throw new \InvalidArgumentException('圖片文件過大。最大允許 5MB。');
        }
        
        // 檢查是否為真實圖片
        if (!$this->isValidImage($file)) {
            throw new \InvalidArgumentException('無效的圖片文件。');
        }
    }

    /**
     * 檢查是否為有效的圖片文件
     */
    protected function isValidImage(UploadedFile $file): bool
    {
        try {
            $image = $this->manager->read($file->getPathname());
            return $image->width() > 0 && $image->height() > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 生成唯一文件名
     */
    protected function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = 'jpg'; // 統一轉換為 JPEG
        $timestamp = now()->format('YmdHis');
        $random = Str::random(8);
        
        return "brand_{$timestamp}_{$random}.{$extension}";
    }

    /**
     * 計算新的圖片尺寸
     */
    protected function calculateNewDimensions(int $width, int $height): array
    {
        // 如果圖片已經小於最大尺寸，保持原尺寸
        if ($width <= $this->maxDimensions && $height <= $this->maxDimensions) {
            return ['width' => $width, 'height' => $height];
        }
        
        // 計算縮放比例
        $ratio = min(
            $this->maxDimensions / $width,
            $this->maxDimensions / $height
        );
        
        return [
            'width' => (int) round($width * $ratio),
            'height' => (int) round($height * $ratio)
        ];
    }

    /**
     * 刪除圖片文件
     */
    public function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            // 在刪除前獲取文件大小
            $fileSize = Storage::disk('public')->size($path);
            $deleted = Storage::disk('public')->delete($path);
      
            return $deleted;
        }
        
        return true; // 文件不存在也算成功
    }

    /**
     * 從 URL 路徑中提取文件路徑
     */
    public function extractPathFromUrl(string $url): string
    {
        $baseUrl = Storage::disk('public')->url('');
        return str_replace($baseUrl, '', $url);
    }

    /**
     * 生成縮略圖
     */
    public function generateThumbnail(string $imagePath, int $width = 150, int $height = 150): string
    {
        $fullPath = Storage::disk('public')->path($imagePath);
        
        if (!file_exists($fullPath)) {
            throw new \InvalidArgumentException('原始圖片文件不存在。');
        }
        
        $image = $this->manager->read($fullPath);
        $image->cover($width, $height);
        
        // 生成縮略圖文件名
        $pathInfo = pathinfo($imagePath);
        $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
        
        // 保存縮略圖
        $processedImage = $image->toJpeg(85);
        Storage::disk('public')->put($thumbnailPath, $processedImage);
        
        return $thumbnailPath;
    }
}
