<?php

declare(strict_types=1);

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var CMain $APPLICATION */
/** @var CBitrixComponent $component */
/** @var array $arParams */
/** @var array $arResult */

$APPLICATION->IncludeComponent(
    componentName: 'ibs.laptops:laptop.detail',
    componentTemplate: '',
    arParams: [
        'CACHE_TIME' => '3600',
        'CACHE_TYPE' => 'A',
        'LAPTOP_ID' => $arResult['VARIABLES']['LAPTOP'] ?? null,
        'SEF_FOLDER' => $arParams['SEF_FOLDER']
    ],
    parentComponent: $component
);
