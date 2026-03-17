<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'https://dashboard.sahorone.com', // ✅ production
        'http://127.0.0.1:8000',          // ✅ local
        'http://localhost:8000',           // ✅ local
    ],
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];
