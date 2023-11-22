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
            'supplier' => 'Supplier Name',
            'supplier_email' => 'Supplier Email',
            'product' => 'Product Name',
            'date' => 'Date',
            'invoice_no' => 'Invoice No',
            'qty' => 'Qty',
            'currency' => 'Currency',
            'price' => 'Price',
            'total' => 'Total',
            'grand-total' => 'Grand Total',
        ],
    ],

    'sale' => [
        'title' => 'Sale',
        'fields' => [
            'customer' => 'Customer Name',
            'customer_email' => 'Customer Email',
            'customer_address' => 'Customer Address',
            'product' => 'Product Name',
            'date' => 'Date',
            'invoice_no' => 'Invoice No',
            'qty' => 'Qty',
            'currency' => 'Currency',
            'price' => 'Price',
            'total' => 'Total',
            'grand-total' => 'Grand Total',
        ],
    ],
];
