<?php

declare(strict_types=1);

namespace IBS\Shop\ORM;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;
use Exception;
use Random\RandomException;

final class DatabaseSeeder
{
    private const MANUFACTURERS = [
        ['TITLE' => 'Lenovo'],
        ['TITLE' => 'Apple'],
        ['TITLE' => 'MSI']
    ];

    private const MODELS = [
        ['TITLE' => 'Ideapad', 'MANUFACTURER_ID' => 1],
        ['TITLE' => 'MacBook Pro', 'MANUFACTURER_ID' => 2],
        ['TITLE' => 'MacBook Air', 'MANUFACTURER_ID' => 2],
        ['TITLE' => 'Modern', 'MANUFACTURER_ID' => 3]
    ];

    private const LAPTOP_TITLES = [
        'Alienware',
        'ROG',
        'ThinkPad',
        'Air',
        'Aspire',
        'XPS',
        'MacBook Pro',
        'Xiaomi',
    ];

    private const OPTIONS = [
        ['TITLE' => 'Wi-Fi 6.0 / 7.0 '],
        ['TITLE' => 'Экран на выбор: FullHD 120 HZ или 4K 60HZ'],
        ['TITLE' => 'Установка до 128гб ОЗУ'],
        ['TITLE' => 'Матрица: VA или IPS'],
    ];

    /**
     * @description Seeds the module database
     *
     * @return void
     */
    public static function seed(): void
    {
        global $APPLICATION;

        try {
            Loader::includeModule(moduleName: 'ibs.laptops');
            self::seedManufacturers();
            self::seedModels();
            self::seedLaptops();
            self::seedOptions();
            self::seedLaptopOptions();
        } catch (Exception $e) {
            $APPLICATION->ThrowException(
                msg: Loc::getMessage(code: 'IBS_LAPTOPS_SEEDER_FAIL') . $e->getMessage()
            );
        }
    }

    /**
     * @description Seeds laptop manufacturers
     *
     * @return void
     *
     * @throws Exception
     */
    private static function seedManufacturers(): void
    {
        global $APPLICATION;

        foreach (self::MANUFACTURERS as $manufacturer) {
            try {
                ManufacturerTable::add(data: $manufacturer);
            } catch (SystemException $e) {
                $APPLICATION->ThrowException(
                    msg: Loc::getMessage(code: 'IBS_LAPTOPS_SEEDER_MANUFACTURER_FAIL') . $e->getMessage()
                );
            }
        }
    }

    /**
     * @description Seeds laptop models
     *
     * @return void
     *
     * @throws Exception
     */
    private static function seedModels(): void
    {
        global $APPLICATION;

        foreach (self::MODELS as $model) {
            try {
                ModelTable::add(data: $model);
            } catch (SystemException $e) {
                $APPLICATION->ThrowException(
                    msg: Loc::getMessage(code: 'IBS_LAPTOPS_SEEDER_MODEL_FAIL') . $e->getMessage()
                );
            }
        }
    }

    /**
     * @description Seeds laptops
     *
     * @return void
     *
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     * @throws RandomException
     * @throws Exception
     */
    private static function seedLaptops(): void
    {
        global $APPLICATION;

        $models = ModelTable::getList(
            parameters: [
                'select' => ['ID', 'TITLE'],
            ]
        )->fetchAll();

        $years = range(start: 2020, end: date(format: 'Y'));


        for ($i = 1; $i <= 40; $i++) {
            $num = random_int(min: 1, max: 5);

            $laptops = [
                'TITLE' => self::LAPTOP_TITLES[array_rand(array: self::LAPTOP_TITLES)] . ' ' . random_int(
                        min: 1,
                        max: 20
                    ),
                'YEAR' => $years[array_rand(array: $years)],
                'PRICE' => random_int(min: 50000, max: 250000),
                'LIST_IMAGE' => '/images/laptops/laptop_' . $num . '_256x256.jpg',
                'DETAIL_IMAGE' => '/images/laptops/laptop_' . $num . '_512x512.jpg',
                'MODEL_ID' => $models[array_rand(array: $models)]['ID'],
            ];

            try {
                LaptopTable::add(data: $laptops);
            } catch (SystemException $e) {
                $APPLICATION->ThrowException(
                    msg: Loc::getMessage(code: 'IBS_LAPTOPS_SEEDER_LAPTOP_FAIL') . $e->getMessage()
                );
            }
        }
    }

    /**
     * @description Seeds laptops options
     *
     * @return void
     *
     * @throws Exception
     */
    private static function seedOptions(): void
    {
        global $APPLICATION;

        foreach (self::OPTIONS as $option) {
            try {
                OptionTable::add(data: $option);
            } catch (SystemException $e) {
                $APPLICATION->ThrowException(
                    msg: Loc::getMessage(code: 'IBS_LAPTOPS_SEEDER_OPTION_FAIL') . $e->getMessage()
                );
            }
        }
    }

    /**
     * @description Seeds laptop options relations
     *
     * @return void
     *
     * @throws RandomException
     * @throws Exception
     */
    private static function seedLaptopOptions(): void
    {
        global $APPLICATION;

        $laptops = LaptopTable::getList(
            parameters: [
                'select' => ['ID', 'TITLE'],
            ]
        )->fetchAll();

        $options = OptionTable::getList(
            parameters: [
                'select' => ['ID', 'TITLE'],
            ]
        )->fetchAll();

        foreach ($laptops as $laptop) {
            $randomOptions = array_rand(array: $options,num: random_int(min: 1, max: count(value: $options)));

            $randomOptions = is_array(value: $randomOptions) ? $randomOptions : [$randomOptions];

            foreach ($randomOptions as $optionIndex) {
                try {
                    LaptopOptionTable::add(
                        data: [
                            'LAPTOP_ID' => $laptop['ID'],
                            'OPTION_ID' => $options[$optionIndex]['ID'],
                        ]
                    );
                } catch (SystemException $e) {
                    $APPLICATION->ThrowException(
                        msg: Loc::getMessage(code: 'IBS_LAPTOPS_SEEDER_LAPTOP_OPTION_FAIL') . $e->getMessage()
                    );
                }
            }
        }
    }
}
