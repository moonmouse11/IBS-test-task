<?php

declare(strict_types=1);

namespace IBS\Shop\ORM;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;

final class ModelTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'b_ibs_models';
    }

    /**
     * @throws SystemException
     * @throws ArgumentException
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
                name: 'MANUFACTURER_ID',
                parameters: [
                    'required' => true,
                ]),
            new Reference(
                name: 'MANUFACTURER',
                referenceEntity: ManufactureTable::class,
                referenceFilter: Join::on('this.MANUFACTURER_ID', 'ref.ID')
            ),
        ];
    }


}
