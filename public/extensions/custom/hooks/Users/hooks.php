<?php

return [
    'filters' => [
        'item.create.directus_users:before' => new \Directus\Custom\Hooks\Users\BeforeInsertUsers()
    ],
    'actions' => [
    ]
];
