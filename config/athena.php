<?php

return [
    'table_prefix' => env('ATHENA_TABLE_PREFIX', ''), // Table prefix for Athena Web Service's tables
    'error_response' => ['Type' => 3],
    'allowed_worlds' => explode(',', env('ATHENA_ALLOWED_WORLDS', 'rAthena')),
    'dump_requests' => env('ATHENA_DUMP_REQUESTS', false),
    'allow_emblem_upload_on_woe' => env('ATHENA_ALLOW_EMBLEM_UPLOAD_ON_WOE', true),
    'log_failed_auth' => env('ATHENA_LOG_FAILED_AUTH'),
];
