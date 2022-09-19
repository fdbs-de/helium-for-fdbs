<?php

use App\Permissions\Permissions;
use App\Permissions\Roles;
use Illuminate\Support\Facades\Facade;

return [

    'permissions' => [
        1 => Permissions::CAN_ACCESS_ADMIN_PANEL,
        2 => Permissions::CAN_EDIT_USERS,
        3 => Permissions::CAN_EDIT_SPECS,
        4 => Permissions::CAN_EDIT_JOB_OFFERS,
        5 => Permissions::CAN_EDIT_DOCS,
    ],

    'roles' => [
        1 => [
            'name' => Roles::SUPER_ADMIN,
            'permissions' => [
                Permissions::CAN_ACCESS_ADMIN_PANEL,
                Permissions::CAN_EDIT_USERS,
                Permissions::CAN_EDIT_SPECS,
                Permissions::CAN_EDIT_JOB_OFFERS,
                Permissions::CAN_EDIT_DOCS,
                Permissions::CAN_EDIT_POSTS,
            ],
        ],
    
        2 => [
            'name' => Roles::ADMIN,
            'permissions' => [
                Permissions::CAN_ACCESS_ADMIN_PANEL,
                Permissions::CAN_EDIT_USERS,
                Permissions::CAN_EDIT_SPECS,
                Permissions::CAN_EDIT_JOB_OFFERS,
                Permissions::CAN_EDIT_DOCS,
                Permissions::CAN_EDIT_POSTS,
            ],
        ],
    
        3 => [
            'name' => Roles::EDITOR,
            'permissions' => [
                Permissions::CAN_ACCESS_ADMIN_PANEL,
                Permissions::CAN_EDIT_SPECS,
                Permissions::CAN_EDIT_JOB_OFFERS,
                Permissions::CAN_EDIT_DOCS,
                Permissions::CAN_EDIT_POSTS,
            ],
        ],
    ],

];
