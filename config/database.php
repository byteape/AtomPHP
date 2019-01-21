<?php
/**
 * 数据库配置文件
 */
return [

    // 必须配置
    'database_type' => 'mysql',
    'database_name' => getenv('DB_NAME'),
    'server'        => getenv('DB_HOST'),
    'username'      => getenv('DB_USERNAME'),
    'password'      => getenv('DB_PASSWORD'),

    // [optional]
    'charset'       => 'utf8mb4',
    'collation'     => 'utf8mb4_general_ci',
    'port'          => getenv('DB_PORT'),

    // [optional] 表前缀
    'prefix'        => getenv('DB_PREFIX'),

    // [optional] 默认情况下禁用日志记录以获得更好的性能
    'logging'       => true,

    // [optional] MySQL socket (shouldn't be used with server and port)
    'socket'        => '/tmp/mysql.sock',

    // [optional] 连接的驱动程序选项，详情了解 http://www.php.net/manual/en/pdo.setattribute.php
    'option'        => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ],

    // [optional] Medoo将在连接到数据库进行初始化后执行这些命令
    'command'       => [
        //启用ANSI_QUOTES后，不能用双引号来引用字符串，因为它被解释为识别符
        'SET SQL_MODE=ANSI_QUOTES'
    ],

];