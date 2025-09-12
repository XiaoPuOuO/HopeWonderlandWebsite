<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\SubBrand;
use App\Services\ImageService;

class CleanupOrphanedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:cleanup {--dry-run : 只顯示會被刪除的文件，不實際刪除}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理沒有被任何子品牌引用的孤兒圖片文件';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $imageService = app(ImageService::class);
        
        $this->info('開始掃描孤兒圖片文件...');
        
        // 獲取所有子品牌正在使用的圖片路徑
        $usedPaths = SubBrand::whereNotNull('logo')
            ->pluck('logo')
            ->toArray();
        
        $this->info('正在使用的圖片文件: ' . count($usedPaths) . ' 個');
        
        // 獲取 brands 目錄下的所有文件
        $allFiles = Storage::disk('public')->files('brands');
        
        $this->info('brands 目錄中的文件: ' . count($allFiles) . ' 個');
        
        $orphanedFiles = [];
        $totalSize = 0;
        
        foreach ($allFiles as $file) {
            if (!in_array($file, $usedPaths)) {
                $orphanedFiles[] = $file;
                $totalSize += Storage::disk('public')->size($file);
            }
        }
        
        if (empty($orphanedFiles)) {
            $this->info('✅ 沒有發現孤兒圖片文件！');
            return 0;
        }
        
        $this->warn('發現 ' . count($orphanedFiles) . ' 個孤兒圖片文件，總大小: ' . $this->formatBytes($totalSize));
        
        if ($isDryRun) {
            $this->info('🔍 乾運行模式 - 以下文件將被刪除:');
            foreach ($orphanedFiles as $file) {
                $size = Storage::disk('public')->size($file);
                $this->line("  - {$file} (" . $this->formatBytes($size) . ")");
            }
            return 0;
        }
        
        if (!$this->confirm('確定要刪除這些孤兒文件嗎？')) {
            $this->info('操作已取消');
            return 0;
        }
        
        $deletedCount = 0;
        $deletedSize = 0;
        
        foreach ($orphanedFiles as $file) {
            $size = Storage::disk('public')->size($file);
            if ($imageService->deleteImage($file)) {
                $deletedCount++;
                $deletedSize += $size;
                $this->line("✅ 已刪除: {$file}");
            } else {
                $this->error("❌ 刪除失敗: {$file}");
            }
        }
        
        $this->info("🎉 清理完成！");
        $this->info("   - 刪除文件: {$deletedCount} 個");
        $this->info("   - 釋放空間: " . $this->formatBytes($deletedSize));
        
        return 0;
    }
    
    /**
     * 格式化字節大小
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}