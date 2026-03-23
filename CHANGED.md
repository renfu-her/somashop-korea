# CHANGED.md

## 2025-03-24 (Asia/Taipei)

### LINE / Open Graph 分享圖片

- 更新 `resources/views/frontend/layouts/app.blade.php`：
  - 將預設 `og:image` 改為 `storage/uploads/019a86a3-6588-7078-8919-87d1194b7e0d.webp`
  - 新增 `og:image:secure_url` 以確保 HTTPS 分享預覽正常
  - 分享 https://somashop.co.kr/ 至 LINE 時，將以該 WebP 圖片作為主要預覽圖
