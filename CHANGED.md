# CHANGED.md

## 2026-11-11 (Asia/Taipei)

### CKEditor 圖片上傳不限大小

- 新增 `app/Http/Requests/Admin/UploadCkeditorImageRequest.php`：
  - 只驗證格式（jpeg、jpg、png、gif、webp），刻意不設 `max`，應用層不再限制上傳大小
- 重構 `app/Http/Controllers/Admin/UploadController.php`：
  - 控制器瘦身，圖片處理改走 `ImageService`
- `app/Services/ImageService.php` 新增 `uploadCkeditorImage()`：
  - 高度超過 800 才往下縮圖，小圖不再被強制放大
  - 修正 `toWebp()` 回傳值被丟掉、實際存成原格式（副檔名 `.webp` 內容卻是 jpeg）的問題
- 備註：實際上限仍受 PHP `upload_max_filesize` / `post_max_size`（目前皆為 10M）與 nginx `client_max_body_size` 限制，超過需調整伺服器設定

## 2025-03-24 (Asia/Taipei)

### LINE / Open Graph 分享圖片

- 更新 `resources/views/frontend/layouts/app.blade.php`：
  - 將預設 `og:image` 改為 `storage/uploads/019a86a3-6588-7078-8919-87d1194b7e0d.webp`
  - 新增 `og:image:secure_url` 以確保 HTTPS 分享預覽正常
  - 分享 https://somashop.co.kr/ 至 LINE 時，將以該 WebP 圖片作為主要預覽圖
