<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'api/wechat/response/*',
        'api/wechat/open',

        /****Android接口****/
        'api/androidapi/login',//登入
        'api/androidapi/goodscategory',//商品分类
        'api/androidapi/goodslist',//商品列表
        'api/androidapi/order_check',//订单提交接口
        /****Android接口****/

    ];
}
