<?php

declare(strict_types=1);

namespace IBS\Shop\ORM;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\SystemException;

final class ManufactureTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'b_ibs_manufacturers';
    }

    /**
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
        ];
    }
}