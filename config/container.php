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

use Illuminate\Container\Container;

//return new Webman\Container;

$container = Container::getInstance();

///// caylof rpc serer
//$container->bind(\Caylof\Rpc\Driver\WorkmanServer::class, fn(Container $container) =>  new \Caylof\Rpc\Driver\WorkmanServer(
//        new \Caylof\Rpc\ServiceCaller(
//            new \Caylof\Rpc\ServiceRepository($container)
//        )
//    )
//);

return $container;