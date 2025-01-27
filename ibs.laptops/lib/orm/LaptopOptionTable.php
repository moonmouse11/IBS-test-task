<?php

declare(strict_types=1);

namespace IBS\Shop\ORM;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;

final class LaptopOptionTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'b_ibs_laptop_option';
    }

    /**
     * @throws ArgumentException
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            new IntegerField(
                name: 'LAPTOP_ID',
                parameters: [
                    'primary' => true,
                ]
            ),
            new IntegerField('OPTION_ID', [
                'primary' => true,
            ]),
            new Reference(
                name: 'LAPTOP',
                referenceEntity:  LaptopTable::class,
                referenceFilter: Join::on('this.LAPTOP_ID', 'ref.ID')
            ),
            new Reference(
                name: 'OPTION',
                referenceEntity: OptionTable::class,
                referenceFilter: Join::on('this.OPTION_ID', 'ref.ID')
            ),
        ];
    }
}
