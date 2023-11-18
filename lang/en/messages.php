<?php

return [
    'panel_name' => 'Inventory Mgmt',

    'category' => [
        'title' => 'Category',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'product' => [
        'title' => 'Products',
        'fields' => [
            'name' => 'Name',
            'category' => 'Category',
            'qty' => 'Quantity',
            'price' => 'Price',
            'photo' => 'Photo',
        ],
    ],

    'customer' => [
        'title' => 'Customers',
        'fields' => [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
        ],
    ],

    'supplier' => [
        'title' => 'Suppliers',
        'fields' => [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
        ],
    ],

    'purchase' => [
        'title' => 'Purchases',
        'fields' => [
        ],
    ],
];
