<?php

try {
    \Bitrix\Main\Loader::registerAutoLoadClasses(
        moduleName: 'ibs.laptops',
        classes: [
            \IBS\Shop\ORM\ModelTable::class => '/lib/orm/ModelTable.php',
            \IBS\Shop\ORM\OptionTable::class => '/lib/orm/OptionTable.php',
            \IBS\Shop\ORM\ManufactureTable::class => '/lib/orm/ManufactureTable.php',
            \IBS\Shop\ORM\LaptopTable::class => '/lib/orm/LaptopTable.php',
            \IBS\Shop\ORM\LaptopOptionTable::class => '/lib/orm/LaptopOptionTable.php',
            \IBS\Shop\ORM\DatabaseSeeder::class => '/lib/orm/DatabaseSeeder.php',
        ]
    );
} catch (\Bitrix\Main\LoaderException $e) {
}