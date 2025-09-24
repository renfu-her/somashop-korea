# Chinese to Korean Translation Documentation

This document contains all the Chinese to Korean translations that have been completed in the SOMA SHOP project.

## Frontend Views Translation

### Navigation & Layout Files

#### main-menu.blade.php
- 關於我們 → 회사 소개 (About Us)
- 活動訊息 → 활동 소식 (Activity News)
- 商品專區 → 상품 전용 (Product Area)
- 會員專區 → 회원 전용 (Member Area)
- 常見問答 → 자주 묻는 질문 (FAQ)
- 個人資料修改 → 개인정보 수정 (Personal Information Modification)
- 訂單查詢 → 주문 조회 (Order Inquiry)
- 登出 → 로그아웃 (Logout)
- 登入 → 로그인 (Login)
- 加入會員 → 회원가입 (Join Member)
- 忘記密碼 → 비밀번호 찾기 (Forgot Password)

#### search.blade.php
- 搜尋 → 검색 (Search)

#### nav.blade.php
- 漢堡選單按鈕 → 햄버거 메뉴 버튼 (Hamburger Menu Button)
- 主選單 → 메인 메뉴 (Main Menu)
- 搜尋欄 → 검색창 (Search Bar)
- 購物車和登入區 → 장바구니 및 로그인 영역 (Cart and Login Area)

### Activity Pages

#### activity/detail.blade.php
- 首頁 → 홈 (Home)
- 活動訊息 → 활동 소식 (Activity News)
- 回列表 → 목록으로 (Back to List)

### Cart & Checkout

#### cart/index.blade.php
- 首頁 → 홈 (Home)
- 購物車 → 장바구니 (Shopping Cart)
- 圖片 → 이미지 (Image)
- 商品名稱 → 상품명 (Product Name)
- 優惠價 → 할인가 (Discount Price)
- 數量 → 수량 (Quantity)
- 小計 → 소계 (Subtotal)
- 刪除 → 삭제 (Delete)
- 總計 → 총계 (Total)
- 我要結帳 → 결제하기 (Checkout)
- 繼續購物 → 쇼핑 계속하기 (Continue Shopping)
- 購物車是空的 → 장바구니가 비어있습니다 (Cart is empty)
- 確定要移除此商品嗎？ → 이 상품을 제거하시겠습니까? (Are you sure you want to remove this product?)
- 更新數量失敗，請稍後再試 → 수량 업데이트 실패, 잠시 후 다시 시도해주세요 (Failed to update quantity, please try again later)
- 移除商品失敗，請稍後再試 → 상품 제거 실패, 잠시 후 다시 시도해주세요 (Failed to remove product, please try again later)

#### checkout/index.blade.php
- 首頁 → 홈 (Home)
- 購物車 → 장바구니 (Shopping Cart)
- 我要結帳 → 결제하기 (Checkout)
- 圖片 → 이미지 (Image)
- 商品名稱 → 상품명 (Product Name)
- 優惠價 → 할인가 (Discount Price)
- 數量 → 수량 (Quantity)
- 小計 → 소계 (Subtotal)
- 總計 → 총계 (Total)
- 付款方式 → 결제 방법 (Payment Method)
- 線上刷卡 → 온라인 카드 결제 (Online Card Payment)
- ATM 虛擬帳號繳費 → ATM 가상계좌 결제 (ATM Virtual Account Payment)
- 貨到付款 (超商取貨付款) → 착불 결제 (편의점 픽업 결제) (Cash on Delivery)
- 收貨人資訊 → 수령인 정보 (Recipient Information)
- 同訂購人資料 → 주문자 정보와 동일 (Same as Orderer Information)
- 收貨姓名 → 수령인 성명 (Recipient Name)
- 請填真實姓名 → 실제 성명을 입력해주세요 (Please enter your real name)
- 性別 → 성별 (Gender)
- 男 → 남성 (Male)
- 女 → 여성 (Female)
- 聯絡電話 → 연락처 (Contact Phone)
- 寄送方式 → 배송 방법 (Shipping Method)
- 請選擇 → 선택해주세요 (Please Select)
- 選擇門市 → 매장 선택 (Select Store)
- 寄送地址 → 배송 주소 (Shipping Address)
- 請入詳細地址 → 상세 주소를 입력해주세요 (Please enter detailed address)
- 訂購備註 → 주문 메모 (Order Notes)
- 開立發票 → 세금계산서 발행 (Invoice Issuance)
- 二聯式 → 2부 (2-part)
- 三聯式 → 3부 (3-part)
- 發票寄送地址 → 세금계산서 배송 주소 (Invoice Shipping Address)
- 發票統編 → 세금계산서 사업자등록번호 (Invoice Business Registration Number)
- 發票抬頭 → 세금계산서 상호 (Invoice Company Name)
- 請輸入 8 位數統編，如果正確，發票抬頭會自動帶入 → 8자리 사업자등록번호를 입력해주세요. 올바르면 세금계산서 상호가 자동으로 입력됩니다 (Please enter 8-digit business registration number, if correct, invoice company name will be automatically filled)
- 輸入右方驗證碼 → 우측 인증번호 입력 (Enter verification code on the right)
- 更換 → 변경 (Change)
- 訂購完成 → 주문 완료 (Order Complete)

### FAQ & Feedback

#### faqs/index.blade.php
- 首頁 → 홈 (Home)
- 常見問答 → 자주 묻는 질문 (FAQ)
- 常見問題 → 자주 묻는 질문 (Common Questions)

#### feedback/index.blade.php
- 問題回饋 → 문의사항 (Inquiry)
- 電子郵件 → 이메일 (Email)
- 訊息內容 → 메시지 내용 (Message Content)
- 請輸入驗證碼 → 인증번호를 입력해주세요 (Please enter verification code)
- 更換 → 변경 (Change)
- 送出訊息 → 메시지 전송 (Send Message)
- 請輸入電子郵件 → 이메일을 입력해주세요 (Please enter email)
- 請輸入有效的電子郵件格式 → 유효한 이메일 형식을 입력해주세요 (Please enter a valid email format)
- 請輸入訊息內容 → 메시지 내용을 입력해주세요 (Please enter message content)
- 驗證碼長度錯誤 → 인증번호 길이가 잘못되었습니다 (Verification code length is incorrect)

### Home & Join

#### home.blade.php
- 活動訊息 → 활동 소식 (Activity News)
- 熱賣商品 → 인기 상품 (Hot Products)
- 新品 → 신상품 (New Product)
- 原價 → 정가 (Original Price)
- 優惠價 → 할인가 (Discount Price)

#### join/index.blade.php
- 加入會員 → 회원가입 (Join Member)
- 首頁 → 홈 (Home)
- 電子郵件 → 이메일 (Email)
- 密碼 → 비밀번호 (Password)
- 至少 8 個字元，包含大小寫英文、數字 → 최소 8자 이상, 대소문자 영문, 숫자 포함 (At least 8 characters, including uppercase and lowercase letters, numbers)
- 再次輸入密碼 → 비밀번호 확인 (Confirm Password)
- 請再輸入一次密碼 → 비밀번호를 다시 입력해주세요 (Please enter password again)
- 姓名 → 성명 (Name)
- 請填真實姓名 → 실제 성명을 입력해주세요 (Please enter your real name)
- 性別 → 성별 (Gender)
- 男 → 남성 (Male)
- 女 → 여성 (Female)
- 生日 → 생년월일 (Birthday)
- 年 → 년 (Year)
- 月 → 월 (Month)
- 日 → 일 (Day)
- 手機 → 휴대폰 (Mobile Phone)
- 請輸入電話 → 전화번호를 입력해주세요 (Please enter phone number)
- 地址 → 주소 (Address)
- 輸入右方驗證碼 → 우측 인증번호 입력 (Enter verification code on the right)
- 更換 → 변경 (Change)
- 我已閱讀會員條款並同意接受條款內容 → 회원약관을 읽고 동의합니다 (I have read and agree to the membership terms)
- 確認送出 → 확인 전송 (Confirm Send)
- 取消重填 → 취소 후 다시 작성 (Cancel and Rewrite)
- 兩次輸入的密碼不一致 → 입력한 비밀번호가 일치하지 않습니다 (The passwords entered do not match)
- 密碼必須為 6~15 字元，且至少包含一個英文字母和數字 → 비밀번호는 6~15자이며, 최소 하나의 영문자와 숫자를 포함해야 합니다 (Password must be 6-15 characters and include at least one letter and number)
- 請輸入有效的手機號碼 → 유효한 휴대폰 번호를 입력해주세요 (Please enter a valid mobile phone number)
- 請填寫完整的地址資訊 → 완전한 주소 정보를 입력해주세요 (Please enter complete address information)
- 請輸入 5 位驗證碼 → 5자리 인증번호를 입력해주세요 (Please enter 5-digit verification code)
- 請同意會員條款 → 회원약관에 동의해주세요 (Please agree to the membership terms)

### Login & Member

#### login/forget.blade.php
- 首頁 → 홈 (Home)
- 忘記密碼 → 비밀번호 찾기 (Forgot Password)
- 請輸入您註冊的電子郵件E-mail，密碼將會寄到您的E-mail信箱。 → 등록하신 이메일 주소를 입력해주세요. 비밀번호가 이메일로 전송됩니다. (Please enter your registered email address. Password will be sent to your email.)
- 電子郵件 → 이메일 (Email)
- 輸入右方驗證碼 → 우측 인증번호 입력 (Enter verification code on the right)
- 更換 → 변경 (Change)
- 確認送出 → 확인 전송 (Confirm Send)
- 取消重填 → 취소 후 다시 작성 (Cancel and Rewrite)

#### login/index.blade.php
- 首頁 → 홈 (Home)
- 會員登入 → 회원 로그인 (Member Login)
- 電子郵件 → 이메일 (Email)
- 密碼 → 비밀번호 (Password)
- 確認送出 → 확인 전송 (Confirm Send)
- 加入會員 → 회원가입 (Join Member)
- 忘記密碼 → 비밀번호 찾기 (Forgot Password)

#### member/agreement.blade.php
- 首頁 → 홈 (Home)
- 會員條款 → 회원약관 (Membership Terms)

### Order & Payment

#### order/list.blade.php
- 首頁 → 홈 (Home)
- 訂單查詢 → 주문 조회 (Order Inquiry)
- 請向左滑 → 왼쪽으로 스와이프하세요 (Please swipe left)
- 訂購日期 → 주문일 (Order Date)
- 訂單編號 → 주문번호 (Order Number)
- 商品 → 상품 (Product)
- 買付金額 → 결제금액 (Payment Amount)
- 運費 → 배송비 (Shipping Fee)
- 狀態 → 상태 (Status)
- 規格 → 규격 (Specification)
- 免運費 → 무료배송 (Free Shipping)
- 付款狀態 → 결제상태 (Payment Status)
- 出貨狀態 → 배송상태 (Shipping Status)
- 訂單狀態 → 주문상태 (Order Status)
- 註 → 참고 (Note)
- 以上資料僅保留六個月內 → 위 자료는 6개월간만 보관됩니다 (The above data is only kept for 6 months)

#### payment/cod-complete.blade.php
- 首頁 → 홈 (Home)
- 購物車 → 장바구니 (Shopping Cart)
- 訂購完成 → 주문 완료 (Order Complete)
- 訂單明細 → 주문 내역 (Order Details)
- 商品 → 상품 (Product)
- 規格 → 규격 (Specification)
- 優惠價 → 할인가 (Discount Price)
- 數量 → 수량 (Quantity)
- 小計 → 소계 (Subtotal)
- 總計 → 총계 (Total)
- 付款方式 → 결제 방법 (Payment Method)
- 刷卡 → 카드 결제 (Card Payment)
- 網路ATM → 온라인 ATM (Online ATM)
- 網路銀行轉帳 → 온라인 뱅킹 (Online Banking)
- 收貨人資訊 → 수령인 정보 (Recipient Information)
- 收貨姓名 → 수령인 성명 (Recipient Name)
- 性別 → 성별 (Gender)
- 男 → 남성 (Male)
- 女 → 여성 (Female)
- 聯絡電話 → 연락처 (Contact Phone)
- 寄送方式 → 배송 방법 (Shipping Method)
- 郵寄 → 우편배송 (Mail Delivery)
- 寄送地址 → 배송 주소 (Shipping Address)
- 7-11 門市取貨 → 7-11 매장 픽업 (7-11 Store Pickup)
- 全家便利商店取貨 → 패밀리마트 픽업 (FamilyMart Pickup)
- 備註 → 메모 (Notes)
- 開立發票 → 세금계산서 발행 (Invoice Issuance)
- 發票寄送地址 → 세금계산서 배송 주소 (Invoice Shipping Address)
- 發票抬頭 → 세금계산서 상호 (Invoice Company Name)
- 發票統編 → 세금계산서 사업자등록번호 (Invoice Business Registration Number)

#### payment/complete.blade.php
- Similar translations as cod-complete.blade.php
- 貨到付款 → 착불 결제 (Cash on Delivery)

#### payment/cod-form.blade.php
- 轉向到綠界支付... → 이커머스 결제로 이동 중... (Redirecting to e-commerce payment...)

#### payment/ecpay-form.blade.php
- 轉向到綠界支付... → 이커머스 결제로 이동 중... (Redirecting to e-commerce payment...)

#### checkout/store-callback.blade.php
- 將資料傳送給父視窗 → 부모 창에 데이터 전송 (Send data to parent window)
- 關閉當前視窗 → 현재 창 닫기 (Close current window)
- 處理中... → 처리 중... (Processing...)

### Product & Search

#### product/detail.blade.php
- 首頁 → 홈 (Home)
- 新品 → 신상품 (New Product)
- 原價 → 정가 (Original Price)
- 優惠價 → 할인가 (Discount Price)
- 規格 → 규격 (Specification)
- 請選擇 → 선택해주세요 (Please Select)
- 數量 → 수량 (Quantity)
- 立即訂購 → 즉시 주문 (Order Now)
- 加入購物車 → 장바구니 담기 (Add to Cart)
- 登入後購買 → 로그인 후 구매 (Login to Purchase)
- 期間 → 기간 (Period)
- 購買商品滿 $X 免運費 → 상품 구매 $X 이상 무료배송 (Free shipping for orders over $X)
- 請選擇商品規格 → 상품 규격을 선택해주세요 (Please select product specification)
- 加入購物車成功 → 장바구니에 추가되었습니다 (Successfully added to cart)
- 加入購物車失敗 → 장바구니 추가 실패 (Failed to add to cart)
- 檢查規格是否已選擇 → 규격 선택 여부 확인 (Check if specification is selected)
- 添加數量增減功能 → 수량 증감 기능 추가 (Add quantity increase/decrease functionality)
- 防止手動輸入非數字或負數 → 수동 입력 시 숫자가 아닌 값이나 음수 방지 (Prevent manual input of non-numeric or negative values)
- 移除非數字字符 → 숫자가 아닌 문자 제거 (Remove non-numeric characters)
- 確保至少為 1 → 최소 1 이상 보장 (Ensure at least 1)

#### product/index.blade.php
- 首頁 → 홈 (Home)

#### search/index.blade.php
- 首頁 → 홈 (Home)
- 搜尋 → 검색 (Search)
- 原價 → 정가 (Original Price)
- 優惠價 → 할인가 (Discount Price)
- 未找到相關商品 → 관련 상품을 찾을 수 없습니다 (No related products found)
- 請嘗試其他關鍵字 → 다른 키워드를 시도해보세요 (Please try other keywords)

### Profile & Other Pages

#### profile/index.blade.php
- 首頁 → 홈 (Home)
- 個人資料修改 → 개인정보 수정 (Personal Information Modification)
- 電子郵件 → 이메일 (Email)
- 密碼 → 비밀번호 (Password)
- 6~15字元，至少搭配 1 個英文字母 → 6~15자, 최소 1개의 영문자 포함 (6-15 characters, at least 1 English letter)
- 再次輸入密碼 → 비밀번호 확인 (Confirm Password)
- 請再輸入一次密碼 → 비밀번호를 다시 입력해주세요 (Please enter password again)
- 手機 → 휴대폰 (Mobile Phone)
- 請輸入電話 → 전화번호를 입력해주세요 (Please enter phone number)
- 地址 → 주소 (Address)
- 請輸入詳細地址 → 상세 주소를 입력해주세요 (Please enter detailed address)
- 確認送出 → 확인 전송 (Confirm Send)
- 取消重填 → 취소 후 다시 작성 (Cancel and Rewrite)

#### seal-knowledge/index.blade.php
- 首頁 → 홈 (Home)
- 認識印章 → 인장 이해 (Understanding Seals)

#### seal-knowledge/detail.blade.php
- 首頁 → 홈 (Home)
- 認識印章 → 인장 이해 (Understanding Seals)

#### post.blade.php
- 首頁 → 홈 (Home)

## Email Templates

### forget-password.blade.php
- 密碼重置通知 → 비밀번호 재설정 안내 (Password Reset Notification)
- 您好 → 안녕하세요 (Hello)
- 您剛在 SOMA SHOP 購物車申請了一組新的密碼。 → SOMA SHOP에서 새로운 비밀번호를 요청하셨습니다. (You have requested a new password from SOMA SHOP.)
- 您的新密碼為： → 새로운 비밀번호는 다음과 같습니다： (Your new password is as follows:)
- 登入後請務必至會員中心修改密碼！ → 로그인 후 반드시 회원센터에서 비밀번호를 변경해주세요！ (Please be sure to change your password in the member center after logging in!)
- 歡迎直接進入EzHive 易群佶選線上購物： → EzHive 온라인 쇼핑몰에 직접 접속하세요： (Welcome to access EzHive online shopping directly:)
- 前往購物網站 → 쇼핑몰 바로가기 (Go to Shopping Site)
- 本信件由系統自動發送，請勿直接回覆本信件，謝謝! → 이 메일은 시스템에서 자동으로 발송된 것으로, 직접 회신하지 마시기 바랍니다. 감사합니다! (This email was automatically sent by the system, please do not reply directly to this email. Thank you!)
- SOMA SHOP 購物車 → SOMA SHOP (Removed redundant "shopping cart" text)

## Controllers

### ForgetController.php
- 验证验证码 → 인증번호 확인 (Verify verification code)
- 驗證碼錯誤 → 인증번호가 잘못되었습니다 (Verification code is incorrect)
- 查找用户 → 사용자 찾기 (Find user)
- 找不到此電子郵件地址 → 해당 이메일 주소를 찾을 수 없습니다 (Cannot find this email address)
- 生成新密码 → 새 비밀번호 생성 (Generate new password)
- 更新用户密码 → 사용자 비밀번호 업데이트 (Update user password)
- 使用 MailService 發送郵件 → MailService를 사용하여 이메일 발송 (Send email using MailService)
- SOMA SHOP 購物車 - 密碼重置通知 → SOMA SHOP - 비밀번호 재설정 안내 (SOMA SHOP - Password Reset Notification)
- 密碼重置通知 → 비밀번호 재설정 안내 (Password Reset Notification)
- 親愛的 {name} 您好，您的新密碼是：{password} 請盡快登入並修改密碼。 → 안녕하세요 {name}님, 새로운 비밀번호는 다음과 같습니다：{password} 빠른 시일 내에 로그인하여 비밀번호를 변경해주세요。 (Hello {name}, your new password is: {password} Please log in and change your password as soon as possible.)
- 前往登入 → 로그인하기 (Go to Login)
- 新密碼已發送至您的郵箱 → 새로운 비밀번호가 이메일로 발송되었습니다 (New password has been sent to your email)

## Common Translation Patterns

### Navigation & UI Elements
- 首頁 → 홈 (Home)
- 購物車 → 장바구니 (Shopping Cart)
- 商品 → 상품 (Product)
- 價格 → 가격 (Price)
- 優惠價 → 할인가 (Discount Price)
- 數量 → 수량 (Quantity)
- 小計 → 소계 (Subtotal)
- 總計 → 총계 (Total)
- 付款 → 결제 (Payment)
- 登入 → 로그인 (Login)
- 會員 → 회원 (Member)
- 密碼 → 비밀번호 (Password)
- 電子郵件 → 이메일 (Email)
- 地址 → 주소 (Address)
- 電話 → 전화 (Phone)
- 確認 → 확인 (Confirm)
- 送出 → 전송 (Send)
- 取消 → 취소 (Cancel)

### Form Labels & Actions
- 請選擇 → 선택해주세요 (Please Select)
- 請輸入 → 입력해주세요 (Please Enter)
- 確認送出 → 확인 전송 (Confirm Send)
- 取消重填 → 취소 후 다시 작성 (Cancel and Rewrite)
- 立即訂購 → 즉시 주문 (Order Now)
- 加入購物車 → 장바구니 담기 (Add to Cart)
- 登入後購買 → 로그인 후 구매 (Login to Purchase)

### Status & Messages
- 成功 → 성공 (Success)
- 失敗 → 실패 (Failure)
- 錯誤 → 오류 (Error)
- 處理中 → 처리 중 (Processing)
- 免運費 → 무료배송 (Free Shipping)
- 新品 → 신상품 (New Product)
- 原價 → 정가 (Original Price)

This comprehensive translation ensures that the entire SOMA SHOP application provides a consistent Korean language experience for users while maintaining all functionality and user experience elements.
