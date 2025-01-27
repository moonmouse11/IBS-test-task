<?php

declare(strict_types=1);

namespace IBS\Shop\ORM;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\FloatField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;

final class LaptopTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'b_ibs_laptops';
    }

    /**
     * @throws ArgumentException
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            new IntegerField(
                name: 'ID',
                parameters: [
                    'primary' => true,
                    'autocomplete' => true,
                ]
            ),
            new StringField(
                name: 'TITLE',
                parameters: [
                    'required' => true,
                ]
            ),
            new IntegerField(
                name: 'MODEL_ID',
                parameters: [
                    'required' => true,
                ]
            ),
            new Reference(
                name: 'MODEL',
                referenceEntity: ModelTable::class,
                referenceFilter: Join::on('this.MODEL_ID', 'ref.ID')
            ),
            new IntegerField(
                name: 'YEAR',
                parameters: [
                    'required' => true,
                ]
            ),
            new FloatField(
                name: 'PRICE',
                parameters: [
                    'required' => true,
                ]
            ),
            new StringField(
                name: 'LIST_IMAGE',
                parameters: [
                    'required' => false,
                ]
            ),
            new StringField(
                name: 'DETAIL_IMAGE',
                parameters: [
                    'required' => false,
                ]
            ),
            new Reference(
                name: 'LAPTOP_OPTIONS',
                referenceEntity: LaptopOptionTable::class,
                referenceFilter: Join::on('this.ID', 'ref.LAPTOP_ID')
            ),

        ];
    }
}
