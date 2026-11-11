<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UploadCkeditorImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * CKEditor 圖片上傳：只驗證型別，不限制檔案大小。
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            // 刻意不加 max 規則，大小一律不受限制
            // 實際上限僅剩 PHP 的 upload_max_filesize / post_max_size
            'upload' => ['required', 'file', 'image', 'mimes:jpeg,jpg,png,gif,webp'],
        ];
    }

    public function messages(): array
    {
        return [
            'upload.required' => '沒有檔案被上傳',
            'upload.image' => '只能上傳圖片檔案',
            'upload.mimes' => '圖片格式僅支援 jpeg、jpg、png、gif、webp',
        ];
    }
}
