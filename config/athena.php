<?php

return [
    'error_response' => ['Type' => 3],
    'allowed_worlds' => explode(',', env('ATHENA_ALLOWED_WORLDS', 'rAthena')),
];
