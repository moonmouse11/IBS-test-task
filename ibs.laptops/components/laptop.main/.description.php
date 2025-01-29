<?php

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = [
    'NAME' => 'Интернет-магазин ноутбуков',
    'DESCRIPTION' => 'Компонент для информационного блока',
    'CACHE_PATH' => 'Y',
    'SORT' => 40,
    'COMPLEX' => 'Y',
    'PATH' => [
        'ID' => 'ibs',
        'NAME' => 'Тестовое задание IBS',
        'CHILD' => [
            'ID' => 'laptops',
            'NAME' => 'Магазин ноутбуков'
        ]
    ]
];