<?php

return [
    "drives" => [
        "public" => [
            "path" => "public/media",
            "name" => "Public",
            "alias" => "public",
            "icon" => "home_storage",
            "usePermissions" => false,
            "public" => true,
        ],
        "private" => [
            "path" => "private/media",
            "name" => "Private",
            "alias" => "private",
            "icon" => "lock",
            "usePermissions" => true,
            "public" => false,
        ],
    ],
];
