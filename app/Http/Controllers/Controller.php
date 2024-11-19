<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * 返回成功訊息
     */
    protected function success($message = '操作成功', $route = null, $data = [])
    {
        if ($route) {
            return redirect()->route($route)
                ->with('success', $message)
                ->with('data', $data);
        }
        return back()->with('success', $message)->with('data', $data);
    }

    /**
     * 返回錯誤訊息
     */
    protected function error($message = '操作失敗', $route = null, $data = [])
    {
        if ($route) {
            return redirect()->route($route)
                ->with('error', $message)
                ->with('data', $data)
                ->withInput();
        }
        return back()->with('error', $message)->with('data', $data)->withInput();
    }

    /**
     * 返回驗證錯誤
     */
    protected function validationError($errors, $route = null)
    {
        if ($route) {
            return redirect()->route($route)
                ->withErrors($errors)
                ->withInput();
        }
        return back()->withErrors($errors)->withInput();
    }

    /**
     * 檢查 CheckMacValue
     * 緑界 CheckMacValue 驗證
     * @param array $params
     * @param string $hashKey
     * @param string $hashIV
     * @param int $encType
     * @return string
     */
    public function checkMacValue(array $params, $hashKey, $hashIV, $encType = 1)
    {
        // 0) 如果資料中有 null，必需轉成空字串
        $params = array_map('strval', $params);

        // 1) 如果資料中有 CheckMacValue 必需先移除
        unset($params['CheckMacValue']);

        // 2) 將鍵值由 A-Z 排序
        uksort($params, 'strcasecmp');

        // 3) 將陣列轉為 query 字串
        $paramsString = urldecode(http_build_query($params));

        // 4) 最前方加入 HashKey，最後方加入 HashIV
        $paramsString = "HashKey={$hashKey}&{$paramsString}&HashIV={$hashIV}";

        // 5) 做 URLEncode
        $paramsString = urlencode($paramsString);

        // dd($paramsString);

        // 6) 轉為全小寫
        $paramsString = strtolower($paramsString);

        // 7) 轉換特定字元(與 dotNet 相符的字元)
        $search  = ['%2d', '%5f', '%2e', '%21', '%2a', '%28', '%29'];
        $replace = ['-',   '_',   '.',   '!',   '*',   '(',   ')'];
        $paramsString = str_replace($search, $replace, $paramsString);

        // 8) 進行編碼
        // dd(md5($paramsString));
        // $paramsString = $encType ? hash('sha256', $paramsString) : md5($paramsString);
        $paramsString = md5($paramsString);

        // 9) 轉為全大寫後回傳
        return strtoupper($paramsString);
    }
}
