## Context

目前產品分類排序已存在於 `categories.sort_order`，後台分類管理頁也依此欄位顯示與編輯，但前台有至少兩條獨立的分類資料流：

- `NavigationController::getProductCategories()` 提供主選單下拉資料
- `ProductController::index()` 與 `ProductController::show()` 另外查一次分類樹提供左側分類選單

雖然兩處都有 `orderBy('sort_order')`，但查詢邏輯重複，未來只要其中一處少了排序、少載一層子分類，或改成其他排序欄位，就會再次產生前台不同入口順序不一致的問題。

## Goals / Non-Goals

**Goals:**
- 建立單一且可重用的產品分類樹查詢方式，統一前台所有產品分類導覽的排序來源。
- 確保父分類、子分類、孫分類都依 `sort_order ASC` 載入。
- 補上可驗證前台導覽一致性的測試，避免回歸。

**Non-Goals:**
- 不變更後台分類編輯 UI 或排序欄位資料結構。
- 不調整產品列表本身的商品排序規則。
- 不處理 FAQ、印章知識等其他模組的分類排序。

## Decisions

1. 將產品分類樹查詢集中到 `Category` model 的 reusable query API。
理由：目前 `NavigationController` 與 `ProductController` 都需要「頂層分類 + 遞迴子分類 + sort_order 排序」；把規則收斂到 model scope 或靜態查詢方法，可避免 controller 複製查詢片段。
替代方案：保留 controller 內各自查詢。這樣改動較小，但排序規則仍分散，風險沒有實質降低。

2. 明確要求所有導覽入口都使用同一分類樹查詢。
理由：問題本質不是單一頁面排序錯誤，而是導覽來源不一致；規格要限制「主選單下拉」與「商品頁左側分類樹」都走同一套排序資料。
替代方案：只修正已知錯誤頁面。這能暫時解決症狀，但之後新增入口時仍容易遺漏。

3. 以 feature test 或 view-facing integration test 驗證導覽順序。
理由：需求是前台顯示順序一致，應從 HTTP / view 層驗證輸出，而不是只測 model query 是否排序。
替代方案：只寫 unit test 驗證 query scope。這無法保證 controller 實際有採用共用查詢。

## Risks / Trade-offs

- [查詢集中後影響既有呼叫點] -> 只抽出前台產品分類樹用途，不直接改寫其他不相關分類查詢，降低擴散面。
- [多層 eager loading 寫法若不一致，子孫分類排序仍可能漏掉] -> 在共用 query 中明確定義每一層 `orderBy('sort_order', 'asc')`，並用測試覆蓋多層分類。
- [現有 Blade 依賴 children 關聯順序] -> 保持回傳資料結構不變，只改資料取得方式，不更動 view contract。
