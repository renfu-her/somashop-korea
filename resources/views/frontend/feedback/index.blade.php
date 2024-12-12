@extends('frontend.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">問題回饋</h4>
                    </div>
                    <div class="card-body">
                        <form id="feedbackForm" action="{{ route('feedback.store') }}" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">電子郵件</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">訊息內容</label>
                                <textarea class="form-control" id="content" name="message" rows="10" required></textarea>
                            </div>

                            <div class="form-group mb-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="verify" name="captcha"
                                        placeholder="請輸入驗證碼" style="text-transform: uppercase; width: 150px;"
                                        oninput="this.value = this.value.toUpperCase()" maxlength="5" required>
                                    <div class="input-group-append d-flex align-items-center">
                                        <span class="mx-2" style="font-size: 20px; letter-spacing: 3px;">
                                            <img src="{{ route('captcha.generate') }}" width="120" height="60"
                                                class="captchaImg" />
                                        </span>
                                        <button type="button" class="btn btn-link btn-refresh"
                                            style="text-decoration: none;">
                                            更換 <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" id="sendFeedback" class="btn btn-primary">送出訊息</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.partials.ckeditor')

@push('scripts')
    <script>
        $('#sendFeedback').on('click', function() {
            const email = $('#email').val();
            const content = editor.getData();
            const captcha = $('#verify').val();

            // 檢查 email 是否為空
            if (!email) {
                window.showToast('請輸入電子郵件');
                return;
            }

            // 驗證 email 格式
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                window.showToast('請輸入有效的電子郵件格式');
                return;
            }

            // 檢查內容是否為空
            if (!content.trim()) {
                window.showToast('請輸入訊息內容');
                return;
            }

            // 檢查驗證碼
            if (captcha.length < 5) {
                window.showToast('驗證碼長度錯誤');
                return;
            }

            $('#feedbackForm').submit();
        });
    </script>
@endpush
