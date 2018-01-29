<?php

return [
    'facebook' => [
        //Id key app facebook - 1000132006804416
        'app-id' => '1000132006804416',
        //Secret key app facebook - 500d21ff9e6dc31642a0d4901fae7139
        'app-secret' => '500d21ff9e6dc31642a0d4901fae7139',
        //call-back uri
        'redirect-uri' => 'http://localhost/user/login?provider=facebook'
    ],
    'google' => [
        //Id key app google - 396873459452-lei11kach2f1163rl4v892nd5e8r2hnr.apps.googleusercontent.com
        'app-id' => '396873459452-lei11kach2f1163rl4v892nd5e8r2hnr.apps.googleusercontent.com',
        //Secret key app google - gsNoPg7qdtCupasMcmW6gQbn
        'app-secret' => 'gsNoPg7qdtCupasMcmW6gQbn',
        //call-back uri
        'redirect-uri' => 'http://localhost/user/login?provider=google'
    ],
];