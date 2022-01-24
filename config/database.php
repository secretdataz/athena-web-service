<?php

$athena_db_connections = [];
function athena_add_server(string $connection, string $host, string $port, string $db, string $uname, string $pwd)
{
    $athena_db_connections[$connection] = [
        'driver' => 'mysql',
        'host' => $host,
        'port' => $port,
        'database' => $db,
        'username' => $uname,
        'password' => $pwd,
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
    ];
}

// athena_add_server('Sakray', 'localhost', 3306, 'dbname', 'username', 'password');

return [
    'default' => env('DB_CONNECTION', env('ATHENA_ALLOWED_WORLDS', 'rAthena')),
    'migrations' => 'migrations',
    'connections' => $athena_db_connections,
];
