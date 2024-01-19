<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Route;

// 给所有OPTIONS请求设置跨域
Route::options('[{path:.+}]', function (){
    return response('');
});


Route::post('/captcha', [\app\controller\CaptchaController::class, 'send']);
Route::post('/signup', [\app\controller\AuthController::class, 'signup']);
Route::post('/login', [\app\controller\AuthController::class, 'login']);

Route::group('', function() {
    Route::get('/me', [\app\controller\AuthController::class, 'meInfo']);
})->middleware([
    new \app\middleware\CheckAuth(new \app\auth\UserAuth()),
]);


// 最后一行加上 关闭默认路由
Route::disableDefaultRoute();
