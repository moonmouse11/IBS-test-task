<?php

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = [
    'NAME' => 'Списки производителей, моделей, ноутбуков',
    'DESCRIPTION' => 'Обрабатывает списки производителей, моделей и ноутбуков',
    'PATH' => [
        'ID' => 'ibs',
        'CHILD' => [
            'ID' => 'laptops',
            'NAME' => 'Управление ноутбуками'
        ],
    ],
];