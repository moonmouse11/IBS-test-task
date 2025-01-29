<?php

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters = [
    'GROUPS' => [
        'SORT_SETTINGS' => [
            'NAME' => 'Настройки сортировки',
        ],
        'PAGINATION_SETTINGS' => [
            'NAME' => 'Настройки постраничной навигации',
        ],
    ],
    'PARAMETERS' => [
        'DEFAULT_SORT_BY' => [
            'PARENT' => 'SORT_SETTINGS',
            'NAME' => 'Поле сортировки по умолчанию',
            'TYPE' => 'LIST',
            'VALUES' => [
                'PRICE' => 'Цена',
                'YEAR' => 'Год выпуска',
            ],
            'DEFAULT' => 'PRICE',
            'ADDITIONAL_VALUES' => 'N',
        ],
        'DEFAULT_SORT_ORDER' => [
            'PARENT' => 'SORT_SETTINGS',
            'NAME' => 'Порядок сортировки по умолчанию',
            'TYPE' => 'LIST',
            'VALUES' => [
                'ASC' => 'По возрастанию',
                'DESC' => 'По убыванию',
            ],
            'DEFAULT' => 'ASC',
            'ADDITIONAL_VALUES' => 'N',
        ],
        'DEFAULT_PAGE_SIZE' => [
            'PARENT' => 'PAGINATION_SETTINGS',
            'NAME' => 'Количество элементов на странице по умолчанию',
            'TYPE' => 'STRING',
            'DEFAULT' => '10',
        ],
        'SEF_FOLDER' => [
            'PARENT' => 'BASE',
            'NAME' => 'Папка ЧПУ (SEF)',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ],
        'SEF_URL_TEMPLATES' => [
            'PARENT' => 'BASE',
            'NAME' => 'Шаблоны URL для ЧПУ (SEF)',
            'TYPE' => 'STRING',
            'MULTIPLE' => 'Y',
            'DEFAULT' => [],
        ],
        'CACHE_TIME' => ['DEFAULT' => 36000000],
    ],
];