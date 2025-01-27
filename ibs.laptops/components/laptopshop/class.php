<?php

declare(strict_types=1);

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\UI\Extension;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;

final class LaptopShop extends CBitrixComponent
{
    /**
     * @return void
     * @throws LoaderException
     * @see parent::executeComponent()
     */
    public function executeComponent(): void
    {
        if (!Loader::includeModule(moduleName: 'ibs.laptops')) {
            ShowError(strError: 'Module ibs.laptops not loaded');
            return;
        }

        if ($this->arParams["SEF_MODE"] != "Y") {
            ShowError(Loc::getMessage('LAPTOPSHOP_MODULE_NOT_SEF_MODE'));
            return;
        }

        $componentPage = $this->sefMode();

        if (!$componentPage) {
            Tools::process404(
                $this->arParams["MESSAGE_404"],
                ($this->arParams["SET_STATUS_404"] === "Y"),
                ($this->arParams["SET_STATUS_404"] === "Y"),
                ($this->arParams["SHOW_404"] === "Y"),
                $this->arParams["FILE_404"]
            );
        }

        $brand = $this->arResult['VARIABLES']['BRAND'] ?? null;
        $model = $this->arResult['VARIABLES']['MODEL'] ?? null;
        $notebook = $this->arResult['VARIABLES']['NOTEBOOK'] ?? null;


        if (!$this->validateParams($brand, $model, $notebook)) {
            foreach ($this->errorCollection as $error) {
                ShowError($error->getMessage());
            }
            return;
        }
        Extension::load("ui.bootstrap4");
        $this->IncludeComponentTemplate($componentPage);
    }


    protected function sefMode(): string
    {
        $arDefaultVariableAliases404 = [];
        $arDefaultUrlTemplates404 = [
            'laptop_detail' => "detail/#NOTEBOOK#/", // Детальная страница ноутбука
            'manufacturer_list' => "", // Список производителей
            'model_list' => "#BRAND#/", // Список моделей производителя
            'laptop_list' => "#BRAND#/#MODEL#/", // Список ноутбуков модели

        ];

        $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates(
            $arDefaultUrlTemplates404,
            $this->arParams["SEF_URL_TEMPLATES"]
        );
        $arVariableAliases = CComponentEngine::makeComponentVariableAliases(
            $arDefaultVariableAliases404,
            $this->arParams["VARIABLE_ALIASES"]
        );

        $engine = new CComponentEngine($this);
        $arVariables = [];

        $componentPage = $engine->guessComponentPath(
            $this->arParams["SEF_FOLDER"],
            $arUrlTemplates,
            $arVariables
        );

        // Проверка на детальную страницу ноутбука
        if ($componentPage === "laptop_detail" && isset($arVariables['NOTEBOOK'])) {
            $componentPage = "laptop_detail";
        } else {
            // Все остальные страницы обрабатываются как список (ноутбуков, моделей, производителей)
            $componentPage = "laptop_list";
        }

        CComponentEngine::initComponentVariables($componentPage, [], $arVariableAliases, $arVariables);

        $this->arResult = [
            "VARIABLES" => $arVariables,
            "ALIASES" => $arUrlTemplates,
        ];

        return $componentPage;
    }

    /**
     * @param $brand
     * @param $model
     * @param $notebook
     * @return bool
     */
    protected function validateParams($brand, $model, $notebook): bool
    {
        $this->errorCollection = new ErrorCollection();

        if ($brand !== null && $brand !== '' && !filter_var($brand, FILTER_VALIDATE_INT)) {
            $this->errorCollection->setError(new Error(Loc::getMessage('LAPTOPSHOP_MODULE_BRAND_ERROR')));
            return false;
        }
        if ($model !== null && $model !== '' && !filter_var($model, FILTER_VALIDATE_INT)) {
            $this->errorCollection->setError(new Error(Loc::getMessage('LAPTOPSHOP_MODULE_MODEL_ERROR')));
            return false;
        }
        if ($notebook !== null && $notebook !== '' && !filter_var($notebook, FILTER_VALIDATE_INT)) {
            $this->errorCollection->setError(new Error(Loc::getMessage('LAPTOPSHOP_MODULE_NOTEBOOK_ERROR')));
            return false;
        }
        return true;
    }
}