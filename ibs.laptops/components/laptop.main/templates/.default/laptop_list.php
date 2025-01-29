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
    componentName: 'ibs.laptops:laptop.list',
    componentTemplate: '',
    arParams: [
        'SEF_FOLDER' => $arParams['SEF_FOLDER'],
        'SEF_URL_TEMPLATES' => $arParams['SEF_URL_TEMPLATES'],
        'VARIABLES' => $arResult['VARIABLES'],
        'COMPONENT_PAGE' => $arResult['COMPONENT_PAGE'],
        'SORT_BY' => 'PRICE',
        'SORT_ORDER' => 'ASC',
        'PAGE_SIZE' => 10,
        'CACHE_TIME' => '3600',
        'CACHE_TYPE' => 'A'
    ],
    parentComponent: $component
);

