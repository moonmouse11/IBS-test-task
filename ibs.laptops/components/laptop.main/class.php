<?php

declare(strict_types=1);

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\UI\Extension;

final class LaptopMainComponent extends CBitrixComponent
{
    /**
     * @description Execute component method
     *
     * @return void
     * @throws LoaderException
     * @see parent::executeComponent()
     */
    public function executeComponent(): void
    {
        if (!Loader::includeModule(moduleName: 'ibs.laptops')) {
            ShowError(strError: Loc::getMessage(code: 'IBS_LAPTOPS_NOT_LOADED'));
            return;
        }

        if ($this->arParams['SEF_MODE'] !== 'Y') {
            ShowError(strError: Loc::getMessage(code: 'IBS_LAPTOPS_NOT_SEF_MODE'));
            return;
        }

        $componentPage = $this->checkSEF();

        if (!$componentPage) {
            Tools::process404(
                $this->arParams['MESSAGE_404'],
                ($this->arParams['SET_STATUS_404'] === 'Y'),
                ($this->arParams['SET_STATUS_404'] === 'Y'),
                ($this->arParams['SHOW_404'] === 'Y'),
                $this->arParams['FILE_404']
            );
        }

        $errorCollection = $this->validateParams(
            manufacturer: $this->arResult['VARIABLES']['MANUFACTURER'] ?? null,
            model: $this->arResult['VARIABLES']['MODEL'] ?? null,
            laptop: $this->arResult['VARIABLES']['LAPTOP'] ?? null
        );

        if (!$errorCollection->isEmpty()) {
            foreach ($errorCollection as $error) {
                ShowError(strError: $error->getMessage());
            }
            return;
        }

        Extension::load(extNames: 'ui.bootstrap4');

        $this->IncludeComponentTemplate(templatePage: $componentPage);
    }

    /**
     * @description get SEF params
     *
     * @return string
     */
    protected function checkSEF(): string
    {
        $arDefaultUrlTemplates = [
            'laptop_detail' => 'detail/#LAPTOP#/',
            'manufacturer_list' => '',
            'model_list' => '#MANUFACTURER#/',
            'laptop_list' => '#MANUFACTURER#/#MODEL#/',
        ];

        $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates(
            arDefaultUrlTemplates: $arDefaultUrlTemplates,
            arCustomUrlTemplates: $this->arParams['SEF_URL_TEMPLATES']
        );
        $arVariableAliases = CComponentEngine::makeComponentVariableAliases(
            arDefaultVariableAliases: [],
            arCustomVariableAliases: $this->arParams['VARIABLE_ALIASES']
        );

        $arVariables = [];

        $componentPage = (new CComponentEngine(component: $this))->guessComponentPath(
            folder404: $this->arParams['SEF_FOLDER'],
            arUrlTemplates: $arUrlTemplates,
            arVariables: $arVariables
        );

        if (!isset($arVariables['LAPTOP'])) {
            $componentPage = 'laptop_list';
        }

        CComponentEngine::initComponentVariables(
            componentPage: $componentPage,
            arComponentVariables: [],
            arVariableAliases: $arVariableAliases,
            arVariables: $arVariables
        );

        $this->arResult = [
            'VARIABLES' => $arVariables,
            'ALIASES' => $arUrlTemplates,
        ];

        return $componentPage;
    }

    /**
     * @description Validate params
     *
     * @param string|null $manufacturer
     * @param string|null $model
     * @param string|null $laptop
     *
     * @return ErrorCollection
     */
    protected function validateParams(?string $manufacturer, ?string $model, ?string $laptop): ErrorCollection
    {
        $errorCollection = new ErrorCollection();

        if (!empty($manufacturer) && !filter_var(value: $manufacturer, filter: FILTER_VALIDATE_INT)) {
            $errorCollection->setError(new Error(message: Loc::getMessage(code: 'IBS_LAPTOPS_MANUFACTURER_ERROR')));
        }
        if (!empty($model) && !filter_var(value: $model, filter: FILTER_VALIDATE_INT)) {
            $errorCollection->setError(new Error(message: Loc::getMessage(code: 'IBS_LAPTOPS_MODEL_ERROR')));
        }
        if (!empty($laptop) && !filter_var(value: $laptop, filter: FILTER_VALIDATE_INT)) {
            $errorCollection->setError(new Error(message: Loc::getMessage(code: 'IBS_LAPTOPS_LAPTOP_ERROR')));
        }

        return $errorCollection;
    }
}