<?php

return [
    'jwt' => [
        'signer_key' => env('JWT_SIGNER_KEY', str_repeat('a', 32)),
    ],
];