## Why

後台已允許調整產品分類排序，但前台只有部分選單正確套用排序，導致主選單下拉與商品頁左側分類導覽顯示順序不一致。這會讓管理端設定失去可信度，也增加使用者在不同入口找到商品分類的成本。

## What Changes

- 定義產品分類排序為前後台共用的單一行為，後台更新 `sort_order` 後，前台所有產品分類導覽都必須反映相同順序。
- 修正前台主導覽下拉與商品頁左側分類樹的資料取得方式，確保父分類、子分類與孫分類皆依 `sort_order` 排序。
- 補上驗證，避免後續新增其他分類入口時再次出現只修部分畫面的情況。

## Capabilities

### New Capabilities
- `product-category-navigation-order`: 定義產品分類在前台所有導覽入口中的一致排序行為。

### Modified Capabilities

## Impact

- Affected code: `app/Http/Controllers/Frontend/NavigationController.php`, `app/Http/Controllers/Frontend/ProductController.php`, `app/Models/Category.php`, 相關 frontend Blade 元件與測試。
- Affected systems: 後台產品分類排序設定、前台主選單下拉、商品列表頁左側分類選單、商品詳情頁左側分類選單。
