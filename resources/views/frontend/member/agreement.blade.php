@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">會員條款</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <article class="page-wrapper my-3">
        <div class="container">
            <div class="page-title">
                <h2 class="text-black text-center font-weight-bold mb-0 aos-init aos-animate" data-aos="zoom-in-up"
                    data-aos-delay="450">會員條款</h2>
                <h4 class="text-center text-gold mb-4 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="600">
                    Membership Terms</h4>
                <hr class="page_line aos-init aos-animate" data-aos="flip-right" data-aos-delay="0"
                    data-aos-duration="3000">
            </div>

            <section class="my-5 aos-init aos-animate" data-aos="zoom-in" data-aos-delay="450">
                <p>歡迎您瀏覽和使用本網站！EzHive 易群佶選 (以下稱「EzHive 易群佶選」)為貫徹對於智慧財產權人之尊重與維護之宗旨，<br>本網站使用須知如下，請您在使用本網站時， 務必遵從下列的條款。</p>
                <br>
                <h4>認知與接受條款</h4>
                <p>為保護 您在本網站提供的個人資訊隱私，謹說明「EzHive 易群佶選」可能蒐集、使用 您個人資料之相關情況及其範圍如下。如果您無法接受或遵守本頁相關條款，請您停止瀏覽及使用本網站。請注意如 您繼續瀏覽或使用本網站，
                    您將被視為接受和同意遵守這些條款。</p>
                <br>
                <h4>會員帳號、密碼及安全</h4>
                <p>會員註冊時，應提供詳實且正確的個人資料，事後如有變更時，請隨時於線上更新。<br>
                    會員應確實填寫會員及各項資料，以確保會員權益。若因會員填寫資料錯誤而產生之任何糾紛，會員不得要求「EzHive 易群佶選」購物網站，給予任何賠償。</p>
                <br>

                <p>會員應該妥善保管密碼，不可以將密碼洩露或提供給其他人知道或使用；以同一個會員email帳號和密碼進入「EzHive 易群佶選」後所進行的所有行為，都將被認為是該會員本人和密碼持有人的行為。<br>
                    會員註冊時必須填寫確實之個人資料，若發現有不實登錄時，「EzHive 易群佶選」得以暫停或終止其會員資格，若違反中華民國相關法律，亦將依法追究。會員如果發現或懷疑有第三人使用其會員email帳號或密碼，應該立即通知「EzHive 易群佶選」，採取必要的必要的防範措施資料之適當性、正確性、及時性及有效性。
                </p>
                <br>

                <p>雖然本網站將努力提供準確和及時的訊息和內容，但這些訊息和內容僅限於其現有狀況，對其準確性和及時性，本網站不給予任何直接或間接的保證。您已瞭解並同意本網站之資料可能含有技術上的不正確或圖文上的錯誤，
                    「EzHive 易群佶選」保留隨時對本網站進行修改及更正之權利；「EzHive 易群佶選」不擔保本網站所含資料或訊息在中華民國境外使用之適當性及有效性，凡自中華民國境外瀏覽本網頁者，應自行負責遵守該地之法律。</p>
                <br>

                <h4>其他免責條款</h4>
                <p>「EzHive 易群佶選」不保證本網站不會發生失誤、錯誤、遺漏、中斷、缺失、傳輸的延誤、電腦病毒、或線路故障等情事，亦無法保證本網站不會因遭病毒或其他有害軟體或程式之侵害所造成您使用上的不便、資料喪失、錯誤、遭人篡改或其他經濟上損失或不利益等狀況。建議您於使用本網站時，應自行採取必要防護措施。「EzHive 易群佶選」對於您使用或無法使用本網站所提供之服務而造成的任何損害，不負賠償責任。
                </p>
                <br>

                <h4>個人資料之蒐集</h4>
                <p>您可自願選擇在本網站上加入成為 「EzHive 易群佶選」會員或是參加「EzHive 易群佶選」舉辦的網路活動或線上抽獎活動等，「EzHive 易群佶選」會從
                    您自願加入會員或參加網路線上活動所填寫上傳的申請表中獲得您的個人資料，包括姓名、出生年月日、性別、地址、電話、電子郵件信箱等項目及 您提供之其他個人資料。</p>
            </section>
        </div>
    </article>
@endpush
