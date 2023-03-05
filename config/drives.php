<?php

return [
    "public" => [
        "provider" => "local",
        "path" => "public/media",
        "name" => "Public",
        "alias" => "public",
        "icon" => "home_storage",
        "private" => false,
        "permission_mode" => "public",
    ],
    "private" => [
        "provider" => "local",
        "path" => "private/media",
        "name" => "Private",
        "alias" => "private",
        "icon" => "lock",
        "private" => true,
        "permission_mode" => "custom",
    ],
];
