<?php

return [
    'driver' => 'bcrypt',
    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 12)
    ],
    'rehash_on_login' => false
];