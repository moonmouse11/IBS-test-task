<?php

$arComponentParameters = [
    'GROUPS' => [
        'VISUAL' => [
            'NAME' => 'Настройки отображения',
        ],
    ],
    'PARAMETERS' => [
        'SHOW_OPTIONS' => [
            'PARENT' => 'VISUAL',
            'NAME' => 'Показывать опции ноутбука',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'CACHE_TYPE' => [
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => 'Тип кэширования',
            'TYPE' => 'LIST',
            'VALUES' => [
                'A' => "Авто",
                'Y' => "Включить",
                'N' => "Выключить",
            ],
            'DEFAULT' => 'A',
        ],
        'CACHE_TIME' => [
            'DEFAULT' => 3600,
        ],
    ],
];