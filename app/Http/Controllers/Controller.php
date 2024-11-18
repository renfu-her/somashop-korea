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
}
