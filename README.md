# e-commerce-template

## 後台管理
- `/admin`
    - 帳號：admin@admin.com 
    - 密碼：Qq123456

- 一般頁面
    - [https://e-commerce-dev.dev-vue.com/](https://e-commerce-dev.dev-vue.com/)
    - ![首頁](https://raw.gitmirror.com/renfu-her/image-drive/main/develop/e-commerce-home.png)

## .env
### 金流
- ECPAY_MERCHANT_ID=
- ECPAY_HASH_KEY=
- ECPAY_HASH_IV=

### 金流測試
- ECPAY_STAGE_MERCHANT_ID=
- ECPAY_STAGE_HASH_KEY=
- ECPAY_STAGE_HASH_IV=

### 電子發票
- ECPAY_INVOICE_MERCHANT_ID=
- ECPAY_INVOICE_HASH_KEY=
- ECPAY_INVOICE_HASH_IV=

### 電子發票測試
- ECPAY_INVOICE_STAGE_MERCHANT_ID=
- ECPAY_INVOICE_STAGE_HASH_KEY=
- ECPAY_INVOICE_STAGE_HASH_IV=

### 電子地圖
- ECPAY_MAP_API=
- ECPAY_STAGE_MAP_API=

### 物流
- ECPAY_SHIPMENT_API=
- ECPAY_SHIPMENT_MERCHANT_ID=
- ECPAY_SHIPMENT_HASH_KEY=
- ECPAY_SHIPMENT_HASH_IV=

### 物流測試
- ECPAY_STAGE_SHIPMENT_API=
- ECPAY_STAGE_SHIPMENT_MERCHANT_ID=
- ECPAY_STAGE_SHIPMENT_HASH_KEY=
- ECPAY_STAGE_SHIPMENT_HASH_IV=

## 視圖結構 (Views Structure)

### 後台視圖 (Admin)
#### 活動管理 (activities/)
- `create.blade.php` - 新增活動
- `edit.blade.php` - 編輯活動
- `index.blade.php` - 活動列表與管理

#### 管理員帳號 (admins/)
- `create.blade.php` - 新增管理員
- `edit.blade.php` - 編輯管理員資料
- `index.blade.php` - 管理員列表

#### 廣告管理 (ads/)
- `create.blade.php` - 新增廣告
- `edit.blade.php` - 編輯廣告
- `index.blade.php` - 廣告列表與管理

#### 認證相關 (auth/)
- `login.blade.php` - 後台登入頁面

#### 購物車管理 (carts/)
- `create.blade.php` - 新增購物車項目
- `edit.blade.php` - 編輯購物車項目
- `index.blade.php` - 購物車列表管理

#### 商品分類 (categories/)
- `create.blade.php` - 新增分類
- `edit.blade.php` - 編輯分類
- `index.blade.php` - 分類列表與管理

#### 郵件設定 (email-settings/)
- `create.blade.php` - 新增郵件設定
- `edit.blade.php` - 編輯郵件設定
- `index.blade.php` - 郵件設定列表

#### FAQ分類 (faq-categories/)
- `create.blade.php` - 新增FAQ分類
- `edit.blade.php` - 編輯FAQ分類
- `index.blade.php` - FAQ分類列表

#### FAQ管理 (faqs/)
- `create.blade.php` - 新增FAQ
- `edit.blade.php` - 編輯FAQ
- `index.blade.php` - FAQ列表與管理

### 共同特點
1. 後台視圖統一使用 `admin.layouts.app` 布局
2. 整合 DataTables 實現數據列表
3. 使用 AJAX 處理狀態切換
4. 表單驗證與錯誤提示
5. 響應式設計
6. 中文化介面

### 特殊功能
- 訂單狀態展開詳情 (前台)
- CKEditor 整合 (FAQ和活動)
- 驗證碼功能 (登入頁)
- 圖片上傳功能 (活動和廣告)

## 前台視圖結構 (Frontend Views Structure)

### 前台視圖 (Frontend)

#### 布局相關 (layouts/)
- `app.blade.php` - 主要布局模板

#### 訂單相關 (order/)
- `list.blade.php` - 訂單列表頁面
  - 包含付款狀態、出貨狀態、訂單狀態的展開詳情
  - 整合 Bootstrap collapse 組件
  - 響應式設計

#### 用戶相關 (user/)
- `profile.blade.php` - 用戶資料頁面
- `orders.blade.php` - 用戶訂單歷史
- `addresses.blade.php` - 收貨地址管理

#### 商品相關 (products/)
- `index.blade.php` - 商品列表頁
- `show.blade.php` - 商品詳情頁
- `category.blade.php` - 分類商品列表

#### 購物車相關 (cart/)
- `index.blade.php` - 購物車頁面
- `checkout.blade.php` - 結帳頁面

#### 會員相關 (auth/)
- `login.blade.php` - 會員登入
- `register.blade.php` - 會員註冊
- `forgot-password.blade.php` - 忘記密碼

#### 其他頁面
- `home.blade.php` - 首頁
- `about.blade.php` - 關於我們
- `contact.blade.php` - 聯絡我們
- `faq.blade.php` - 常見問題
- `privacy.blade.php` - 隱私政策
- `terms.blade.php` - 使用條款

### 共同特點
1. 所有前台頁面統一使用 `frontend.layouts.app` 布局
2. 響應式設計適配各種設備
3. 整合 Bootstrap 5 框架
4. 多語系支援
5. SEO 優化相關 meta 標籤

### 特殊功能
1. 訂單狀態展開詳情
2. 購物車即時更新
3. 商品圖片預覽
4. 地址選擇器
5. 金流整合介面

## 目錄結構樹狀圖
```
resources/
├── views/
├── admin/ # 後台視圖
│ ├── activities/ # 活動管理
│ │ ├── create.blade.php # - 新增活動
│ │ ├── edit.blade.php # - 編輯活動
│ │ └── index.blade.php # - 活動列表
│ │
│ ├── admins/ # 管理員管理
│ │ ├── create.blade.php # - 新增管理員
│ │ ├── edit.blade.php # - 編輯管理員
│ │ └── index.blade.php # - 管理員列表
│ │
│ ├── ads/ # 廣告管理
│ │ ├── create.blade.php # - 新增廣告
│ │ ├── edit.blade.php # - 編輯廣告
│ │ └── index.blade.php # - 廣告列表
│ │
│ ├── auth/ # 認證相關
│ │ └── login.blade.php # - 登入頁面
│ │
│ ├── carts/ # 購物車管理
│ │ ├── create.blade.php # - 新增購物車項目
│ │ ├── edit.blade.php # - 編輯購物車項目
│ │ └── index.blade.php # - 購物車列表
│ │
│ ├── categories/ # 商品分類管理
│ │ ├── create.blade.php # - 新增分類
│ │ ├── edit.blade.php # - 編輯分類
│ │ └── index.blade.php # - 分類列表
│ │
│ ├── email-settings/ # 郵件設定
│ │ ├── create.blade.php # - 新增設定
│ │ ├── edit.blade.php # - 編輯設定
│ │ └── index.blade.php # - 設定列表
│ │
│ ├── faq-categories/ # FAQ分類管理
│ │ ├── create.blade.php # - 新增FAQ分類
│ │ ├── edit.blade.php # - 編輯FAQ分類
│ │ └── index.blade.php # - FAQ分類列表
│ │
│ ├── faqs/ # FAQ管理
│ │ ├── create.blade.php # - 新增FAQ
│ │ ├── edit.blade.php # - 編輯FAQ
│ │ └── index.blade.php # - FAQ列表
│ │
│ └── layouts/ # 後台布局
│ └── app.blade.php # - 主布局文件
│
└── frontend/ # 前台視圖
├── layouts/ # 前台布局
│ └── app.blade.php # - 主布局文件
│
├── order/ # 訂單相關
│ └── list.blade.php # - 訂單列表
│
├── user/ # 用戶中心
│ ├── profile.blade.php # - 個人資料
│ ├── orders.blade.php # - 訂單記錄
│ └── addresses.blade.php # - 收貨地址
│
├── products/ # 商品相關
│ ├── index.blade.php # - 商品列表
│ ├── show.blade.php # - 商品詳情
│ └── category.blade.php # - 分類商品
│
├── cart/ # 購物車相關
│ ├── index.blade.php # - 購物車頁面
│ └── checkout.blade.php # - 結帳頁面
│
├── auth/ # 會員認證
│ ├── login.blade.php # - 登入頁面
│ ├── register.blade.php # - 註冊頁面
│ └── forgot-password.blade.php # - 忘記密碼
│
└── pages/ # 靜態頁面
├── home.blade.php # - 首頁
├── about.blade.php # - 關於我們
├── contact.blade.php # - 聯絡我們
├── faq.blade.php # - 常見問題
├── privacy.blade.php # - 隱私政策
└── terms.blade.php # - 使用條款
```