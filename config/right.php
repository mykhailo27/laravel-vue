<?php


return [
    'roles' => [
        'admin',
        'manager',
        'seller',
        'financier',
        'developer',
        'editor',
        'designer',
        'user',
        'guest'
    ],

    'permissions' => [
        'create.product', 'edit.product', 'view.product', 'update.product', 'delete.product', 'restore.product',
        'create.package', 'edit.package', 'view.package', 'update.package', 'delete.package', 'restore.package',
        'create.shipment', 'edit.shipment', 'view.shipment', 'update.shipment', 'delete.shipment', 'restore.shipment',
    ]
];
