<?php

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arModuleVersion = [
    'VERSION' => '1.0.0',
    'VERSION_DATE' => '2025-01-27'
];

$arDescription = [
    'ID' => 'ibs.laptops',
    'NAME' => 'Магазин ноутбуков',
    'DESCRIPTION' => 'Тестовое задания для IBS',
    'SORT' => 100,
    'PARTNER_NAME' => 'IBS',
    'PARTNER_URI' => 'https://github.com/moonmouse11',
    'VERSION' => $arModuleVersion['VERSION'],
    'VERSION_DATE' => $arModuleVersion['VERSION_DATE'],
];