# SOMA SHOP 購物車

## 專案介紹
SOMA SHOP 購物車是一個基於 Laravel 的電商平台範例專案，提供前台用戶瀏覽商品、加入購物車、結帳購買、訂單管理；後台管理商品、分類、活動、廣告、FAQ、郵件設定等功能，並整合綠界 ECPay 金流、電子發票與物流服務。

## 核心功能
- 會員註冊、登入與忘記密碼
- 商品分類與搜尋、商品詳情
- 購物車管理與結帳流程
- 訂單維護、物流狀態查詢
- 郵件佇列（EmailQueue）與批次處理
- 後台管理系統：
  - 商品、商品分類、活動、廣告、FAQ 分類與內容
  - 管理員帳號管理
  - 郵件設定管理
  - 購物車資料維護
  - CKEditor 編輯器整合
  - DataTables 數據列表

## 環境需求
- PHP >= 8.x
- Composer
- MySQL
- Laravel ^9.0
- （可選）Node.js、npm 或 yarn 用於前端資產編譯

## 快速上手
1. 取得原始碼並進入專案根目錄：
   ```bash
   git clone <repo_url> ezhive
   cd ezhive
   ```
2. 安裝 PHP 套件：
   ```bash
   composer install
   ```
3. 複製環境設定檔並產生應用金鑰：
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. 編輯 `.env`，設定資料庫與金流參數：
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ezhive
   DB_USERNAME=root
   DB_PASSWORD=

   # 綠界金流 ECPAY
   ECPAY_MERCHANT_ID=
   ECPAY_HASH_KEY=
   ECPAY_HASH_IV=

   # 電子發票
   ECPAY_INVOICE_MERCHANT_ID=
   ECPAY_INVOICE_HASH_KEY=
   ECPAY_INVOICE_HASH_IV=

   # 物流
   ECPAY_SHIPMENT_API=
   ECPAY_SHIPMENT_MERCHANT_ID=
   ECPAY_SHIPMENT_HASH_KEY=
   ECPAY_SHIPMENT_HASH_IV=
   ```
5. 建立資料表並匯入預設種子：
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
6. （可選）安裝並編譯前端資產：
   ```bash
   npm install
   npm run dev
   ```

## 目錄結構
```
app/
├── Http/Controllers/Frontend    # 前台控制器
├── Http/Controllers/Admin       # 後台控制器
├── Models                       # Eloquent 模型
│   ├── Member.php
│   ├── Order.php
│   └── EmailQueue.php
└── Services                     # 自訂服務
    └── MailService.php          # 郵件佇列與發送邏輯
resources/views/
├── frontend/layouts/app.blade.php    # 前台主布局
├── frontend/                   # 前台頁面
├── emails/                     # 郵件樣板
│   ├── layout.blade.php
│   ├── forget-password.blade.php
│   └── order-complete.blade.php
└── admin/                      # 後台頁面
```

## 常用 Artisan 指令
- `php artisan serve`：啟動本地開發伺服器
- `php artisan migrate`：執行資料庫遷移
- `php artisan db:seed`：匯入種子資料
- `php artisan logistics:check`：檢查物流狀態
- `php artisan email:process`：處理郵件佇列

## 後台預設帳號
- 帳號：admin@admin.com
- 密碼：Qq123456

## 注意事項
- `.env` 預設為綠界測試環境參數，如要切換正式環境請更新相應值。
- 前後台視圖皆整合響應式設計與多語系支援。

## 貢獻
歡迎提交 Issue 與 Pull Request，一起完善 EzHive 易群佑選購物車！
