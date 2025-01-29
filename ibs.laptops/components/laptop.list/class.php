<?php

declare(strict_types=1);

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\UI\PageNavigation;
use IBS\Shop\ORM\LaptopTable;
use IBS\Shop\ORM\ManufacturerTable;
use IBS\Shop\ORM\ModelTable;

final class LaptopListComponent extends CBitrixComponent
{

    /**
     * @description Execute component
     *
     * @return void
     *
     * @throws LoaderException
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     *
     * @see parent::executeComponent()
     */
    public function executeComponent(): void
    {
        if (!Loader::includeModule(moduleName: 'ibs.laptops')) {
            ShowError(strError: Loc::getMessage(code: 'IBS_LAPTOPS_NOT_LOADED'));
            return;
        }

        $this->checkSEF();
        $componentPage = $this->arResult['COMPONENT_PAGE'];
        $usePagination = false;


        if ($componentPage === 'manufacturer_list') {
            $className = ManufacturerTable::class;
            $parameters = [
                'select' => ['ID', 'TITLE'],
                'order' => ['TITLE' => 'ASC']
            ];
        }

        if ($componentPage === 'model_list') {
            $className = ModelTable::class;
            $parameters = [
                'select' => ['ID', 'TITLE'],
                'filter' => ['MANUFACTURER.ID' => $this->arResult['VARIABLES']['MANUFACTURER']],
                'order' => ['TITLE' => 'ASC']
            ];
        }

        if ($componentPage === 'laptop_list') {
            $className = LaptopTable::class;
            $parameters = [
                'select' => ['ID', 'TITLE', 'YEAR', 'PRICE', 'LIST_IMAGE', 'DETAIL_IMAGE'],
                'filter' => ['MODEL.ID' => $this->arResult['VARIABLES']['MODEL']],
            ];
            $usePagination = true;
        }

        if ($usePagination) {
            $pageNavigation = $this->getPagination();
            $parameters['limit'] = $pageNavigation->getLimit();
            $parameters['offset'] = $pageNavigation->getOffset();

            $request = Context::getCurrent()?->getRequest();

            $sortBy = in_array(needle: $request->getQuery(name: 'sort_by'), haystack: ['PRICE', 'YEAR'], strict: false)
                ? $request->getQuery(name: 'sort_by')
                : 'PRICE';

            $sortOrder = in_array(
                needle: $request->getQuery(name: 'sort_order'),
                haystack: ['ASC', 'DESC'],
                strict: false
            )
                ? $request->getQuery(name: 'sort_order')
                : 'ASC';

            $parameters['order'] = [$sortBy => $sortOrder];

            $this->arResult['REQUEST'] = Context::getCurrent()?->getRequest();
        }

        if ($componentPage !== '') {
            $items = $className::getList(parameters: $parameters);

            if ($usePagination) {
                $totalCount = $className::getCount(filter: $parameters['filter']);
                $pageNavigation->setRecordCount(n: $totalCount);
                $this->arResult['NAV_OBJECT'] = $pageNavigation;
            }

            foreach ($items as $item) {
                $this->arResult['DATA'][] = $item;
            }
        }
        $this->includeComponentTemplate(templatePage: $componentPage);
    }


    /**
     * @description Check SEF route of component
     *
     * @return void
     */
    protected function checkSEF(): void
    {
        $arVariables = [];
        $arDefaultUrlTemplates404 = [
            'manufacturer_list' => '',
            'model_list' => '#MANUFACTURER#/',
            'laptop_list' => '#MANUFACTURER#/#MODEL#/',
        ];

        $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates(
            arDefaultUrlTemplates: $arDefaultUrlTemplates404,
            arCustomUrlTemplates: $this->arParams['SEF_URL_TEMPLATES']
        );

        $engine = new CComponentEngine(component: $this);

        $componentPage = $engine->guessComponentPath(
            folder404: $this->arParams['SEF_FOLDER'],
            arUrlTemplates: $arUrlTemplates,
            arVariables: $arVariables
        );

        if (!$componentPage) {
            $componentPage = 'manufacturer_list';
        }

        CComponentEngine::initComponentVariables(
            componentPage: $componentPage,
            arComponentVariables: [],
            arVariableAliases: [],
            arVariables: $arVariables
        );

        $this->arResult['VARIABLES'] = $arVariables;
        $this->arResult['COMPONENT_PAGE'] = $componentPage;
    }


    /**
     * @description Get pagination number
     *
     * @return PageNavigation
     */
    protected function getPagination(): PageNavigation
    {
        $request = Context::getCurrent()?->getRequest();

        $pageSize = max((int)$request->getQuery(name: 'page_size'), 5);

        $pageNumber = max(
            str_replace(search: 'page-', replace: '', subject: $request->getQuery(name: 'page') ?? '1'),
            1
        );

        $nav = new PageNavigation('page');
        $nav->allowAllRecords(false)
            ->setPageSize($pageSize)
            ->setCurrentPage($pageNumber);

        return $nav;
    }
}