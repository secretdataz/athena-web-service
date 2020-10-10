<?php

return [
    'error_response' => ['Type' => 3],
    'allowed_worlds' => explode(',', env('ATHENA_ALLOWED_WORLDS', 'rAthena')),
    'dump_requests' => env('ATHENA_DUMP_REQUESTS', false),
    'allow_emblem_upload_on_woe' => env('ATHENA_ALLOW_EMBLEM_UPLOAD_ON_WOE', true),
];
