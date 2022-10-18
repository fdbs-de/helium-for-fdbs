<?php

return [
    'groups' => [
        'static' => [
            'ie',
            'home',
            'philosophie',
            'philosophie.*',
            'produkte-und-services',
            'ps.*',
            'karriere',
            'karriere.*',
            'kontakt',
            'kontakt.*',
            'impressum',
            'datenschutz',
            'agbs',
            'video-info',
            'docs',
            'docs.*',
        ],
        'guest' => [
            'login',
            'registrieren',
            'password.*',
        ],
        'authenticated' => [
            'verification.*',
            'logout',
            'dashboard',
            'dashboard.profile',
            'dashboard.profile.*',
        ],
        'admin' => [
            'dashboard.admin',
            'dashboard.admin.*',
        ],
        'customer' => [
            'dashboard.customer',
            'dashboard.customer.*',
        ],
        'employee' => [
            'dashboard.employee',
            'dashboard.employee.*',
        ],
    ],
];