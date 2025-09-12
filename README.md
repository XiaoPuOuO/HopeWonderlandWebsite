# HopeWonderland Studio 品牌官網

這是一個為 HopeWonderland Studio 設計的現代化品牌官網，使用 Laravel 框架開發，採用 Vite 作為前端構建工具。

## 功能特色

### 🎨 前端功能
- **響應式設計**：適配各種設備尺寸
- **現代化 UI**：使用自定義 CSS 打造美觀界面
- **品牌展示**：展示 HopeWonderland Studio 的品牌形象
- **子品牌網站**：展示和管理多個子品牌網站連結
- **聯絡表單**：方便客戶聯繫

### 🔧 管理後台
- **子品牌網站管理**：完整的 CRUD 功能
- **視覺化編輯**：色彩選擇器、標籤管理
- **狀態控制**：啟用/停用子品牌網站
- **排序功能**：自定義子品牌網站顯示順序

## 技術架構

- **後端**：Laravel 10
- **前端構建**：Vite
- **樣式**：自定義 CSS（不使用 Tailwind）
- **JavaScript**：原生 JavaScript + ES6
- **字體**：Noto Sans TC（繁體中文）
- **圖標**：Font Awesome

## 前端資源結構

```
resources/
├── css/
│   ├── app.css          # 主樣式檔案
│   └── admin.css        # 管理後台專用樣式
└── js/
    └── app.js           # 主 JavaScript 檔案
```

## 安裝與設置

### 1. 環境要求
- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL 或 SQLite

### 2. 安裝步驟

```bash
# 克隆項目
git clone [repository-url]
cd HopeWonderlandWebsite

# 安裝 PHP 依賴
composer install

# 安裝前端依賴
npm install

# 複製環境配置文件
cp .env.example .env

# 生成應用密鑰
php artisan key:generate

# 配置數據庫（在 .env 文件中）
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hopewonderland_studio
DB_USERNAME=your_username
DB_PASSWORD=your_password

# 運行數據庫遷移
php artisan migrate

# 編譯前端資源
npm run build
```

### 3. 開發模式

```bash
# 啟動 Laravel 開發服務器
php artisan serve

# 在另一個終端啟動前端監聽（開發模式）
npm run dev
```

## 使用說明

### 前端頁面

1. **首頁** (`/`)
   - 品牌介紹
   - 子品牌網站展示
   - 聯絡資訊

### 管理後台

1. **子品牌網站管理** (`/admin/sub-brands`)
   - 查看所有子品牌網站
   - 新增子品牌網站
   - 編輯子品牌網站資訊
   - 刪除子品牌網站

2. **子品牌網站欄位說明**
   - **品牌名稱**：子品牌的名稱
   - **URL 標識符**：用於網址的友好標識
   - **品牌描述**：子品牌的詳細描述
   - **Logo 路徑**：子品牌 Logo 的檔案路徑
   - **官網連結**：子品牌的官方網站（重要！）
   - **主要色彩**：品牌的主要顏色
   - **次要色彩**：品牌的次要顏色
   - **標籤**：用於分類的標籤
   - **排序順序**：控制顯示順序
   - **啟用狀態**：是否在前端顯示

## 檔案結構

```
HopeWonderlandWebsite/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php          # 首頁控制器
│   │   └── Admin/
│   │       └── SubBrandController.php  # 子品牌管理控制器
│   └── Models/
│       └── SubBrand.php               # 子品牌模型
├── database/
│   └── migrations/
│       └── create_sub_brands_table.php # 子品牌數據表
├── resources/
│   ├── css/
│   │   ├── app.css                    # 主樣式檔案
│   │   └── admin.css                  # 管理後台樣式
│   ├── js/
│   │   └── app.js                     # 主 JavaScript 檔案
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php          # 前端佈局
│       │   └── admin.blade.php        # 管理後台佈局
│       ├── home.blade.php             # 首頁
│       └── admin/
│           └── sub-brands/
│               ├── index.blade.php    # 子品牌列表
│               ├── create.blade.php   # 新增子品牌
│               ├── edit.blade.php     # 編輯子品牌
│               └── show.blade.php     # 子品牌詳情
├── public/
│   ├── images/
│   │   └── icon.png                   # 品牌圖標
│   └── build/                         # Vite 編譯後的資源
└── routes/
    └── web.php                        # 路由定義
```

## 前端開發

### CSS 架構
- 使用 CSS 變數定義主題色彩
- 響應式設計使用媒體查詢
- 模組化 CSS 類別設計
- 支援深色/淺色主題切換

### JavaScript 功能
- 模組化 JavaScript 設計
- 表單驗證和錯誤處理
- 色彩選擇器同步
- 標籤管理功能
- 通知系統

### Vite 配置
```javascript
// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/admin.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
```

## 自定義指南

### 1. 修改品牌資訊
- 編輯 `resources/views/layouts/app.blade.php` 中的品牌名稱和描述
- 更換 `public/images/icon.png` 為您的品牌圖標

### 2. 修改色彩主題
- 編輯 `resources/css/app.css` 中的 CSS 變數
- 主要變數包括：`--primary-color`、`--secondary-color` 等

### 3. 添加新功能
- 在 `app/Http/Controllers/` 中創建新的控制器
- 在 `resources/views/` 中創建對應的視圖
- 在 `routes/web.php` 中添加新的路由
- 在 `resources/js/app.js` 中添加對應的 JavaScript 功能

### 4. 數據庫擴展
- 創建新的遷移檔案：`php artisan make:migration create_[table_name]_table`
- 更新對應的模型和控制器

## 部署建議

### 生產環境設置
1. 設置 `APP_ENV=production`
2. 設置 `APP_DEBUG=false`
3. 配置適當的數據庫連接
4. 設置檔案上傳目錄權限
5. 配置 Web 服務器（Apache/Nginx）

### 性能優化
1. 啟用 Laravel 快取：`php artisan config:cache`
2. 優化路由：`php artisan route:cache`
3. 優化視圖：`php artisan view:cache`
4. 編譯前端資源：`npm run build`
5. 使用 CDN 加速靜態資源

## 開發命令

```bash
# 前端開發
npm run dev          # 開發模式，支援熱重載
npm run build        # 生產環境編譯
npm run watch:build  # 監聽檔案變化並自動編譯

# Laravel 命令
php artisan serve    # 啟動開發服務器
php artisan migrate  # 運行數據庫遷移
php artisan db:seed  # 填充示例數據
```

## 支援與維護

如有問題或需要功能擴展，請聯繫開發團隊。

---

**HopeWonderland Studio** - 創意設計工作室
