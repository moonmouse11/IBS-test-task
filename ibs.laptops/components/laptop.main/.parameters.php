<?php

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters = [
    'PARAMETERS' => [
        'SEF_MODE' => [
            'unifield_list' => [
                'NAME' => 'Список элементов',
                'DEFAULT' => '#MANUFACTURER#/#MODEL#/',
                'VARIABLES' => ['MANUFACTURER', 'MODEL'],
            ],
            'laptop_detail' => [
                'NAME' => 'Детальная страница ноутбука',
                'DEFAULT' => 'detail/#LAPTOP#/',
                'VARIABLES' => ['LAPTOP'],
            ],
        ],
        'SEF_FOLDER' => [
            'PARENT' => 'BASE',
            'NAME' => 'Каталог для SEF URL',
            'TYPE' => 'STRING',
            'DEFAULT' => '/laptops/',
        ],
    ],
];