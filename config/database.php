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

return [
    'default' => 'mysql',

    'connections' => [
        'mysql' => [
            'driver'      => 'mysql',
            'host'        => env('DB_HOST', 'mysql'),
            'port'        => env('DB_PORT', 3306),
            'database'    => env('DB_NAME', 'test'),
            'username'    => env('DB_USER', 'root'),
            'password'    => env('DB_PASSWORD', 'root'),
            'charset'     => 'utf8mb4',
            'collation'   => 'utf8mb4_general_ci',
            'prefix'      => '',
            'strict'      => true,
            'engine'      => null,
            'options'     => [
                \PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ],

//        'sqlite' => [
//            'driver' => 'sqlite',
//            'url' => env('DATABASE_URL'),
//            'database' => env('DB_DATABASE', runtime_path('database.sqlite')),
//            'prefix' => '',
//            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
//        ],
    ],
];
