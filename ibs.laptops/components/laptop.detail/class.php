<?php

declare(strict_types=1);

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use IBS\Shop\ORM\LaptopOptionTable;
use IBS\Shop\ORM\LaptopTable;
use IBS\Shop\ORM\OptionTable;

final class LaptopDetailComponent extends CBitrixComponent
{
    /**
     * @description Execute component.
     *
     * @return void
     *
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws LoaderException
     * @throws ObjectPropertyException
     * @throws SystemException
     *
     * @see parent::executeComponent()
     */
    public function executeComponent(): void
    {
        if (!Loader::includeModule(moduleName: 'ibs.laptops')) {
            ShowError(strError: 'Module ibs.laptops not loaded');
        }

        $laptopId = (int)$this->arParams['LAPTOP_ID'];

        $laptop = LaptopTable::query()
            ->setSelect(select: ['*', 'MODEL', 'MODEL.MANUFACTURER'])
            ->where('ID' ,$laptopId)
            ->fetchObject();

        if ($laptop) {
            $this->arResult['LAPTOP'] = [
                'TITLE' => $laptop->getTitle(),
                'MODEL_TITLE' => $laptop->getModel() ? $laptop->getModel()->getTitle() : '',
                'MANUFACTURER_TITLE' => $laptop->getModel() && $laptop->getModel()->getManufacturer()
                    ? $laptop->getModel()->getManufacturer()->getTitle()
                    : '',
                'PRICE' => $laptop->getPrice() ?? '',
                'YEAR' => $laptop->getYear() ?? '',
                'DETAIL_IMAGE' => $laptop->getDetailImage(),
            ];

            $this->arResult['OPTIONS'] = $this->getLaptopOptions(laptopId: $laptopId);
        } else {
            throw new ArgumentNullException(parameter: 'LAPTOP_ID');
        }

        $this->includeComponentTemplate();
    }


    /**
     * @description Get laptop options list.
     *
     * @param int $laptopId
     * @return array
     *
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    private function getLaptopOptions(int $laptopId): array
    {
        return LaptopOptionTable::getList(
            parameters: [
                'select' => ['OPTION_ID', 'OPTION_TITLE' => 'OPTION.TITLE'],
                'filter' => ['LAPTOP_ID' => $laptopId],
                'runtime' => [
                    new ReferenceField(
                        name: 'OPTION',
                        referenceEntity: OptionTable::getEntity(),
                        referenceFilter: ['=this.OPTION_ID' => 'ref.ID'],
                        parameters: ['join_type' => 'LEFT']
                    )
                ]
            ]
        )->fetchAll();
    }
}
