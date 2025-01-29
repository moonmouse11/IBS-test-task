<?php

declare(strict_types=1);

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\IO\InvalidPathException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Context;
use Bitrix\Main\IO\Directory;
use IBS\Shop\ORM\DatabaseSeeder;
use IBS\Shop\ORM\LaptopOptionTable;
use IBS\Shop\ORM\LaptopTable;
use IBS\Shop\ORM\ManufacturerTable;
use IBS\Shop\ORM\ModelTable;
use IBS\Shop\ORM\OptionTable;

final class ibs_laptops extends CModule
{
    public function __construct()
    {
        $arModuleVersion = [];
        require_once __DIR__ . '/version.php';

        $this->MODULE_ID = 'ibs.laptops';
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage(code: 'IBS_LAPTOPS_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage(code: 'IBS_LAPTOPS_MODULE_DESC');

        $this->PARTNER_NAME = Loc::getMessage(code: 'IBS_LAPTOPS_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage(code: 'IBS_LAPTOPS_PARTNER_URI');

        $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
        $this->MODULE_GROUP_RIGHTS = 'Y';
    }

    /**
     * @throws LoaderException
     */
    public function InstallDB(): bool
    {
        Loader::includeModule(moduleName: $this->MODULE_ID);

        $connection = Application::getConnection();

        $models = [
            ManufacturerTable::class,
            ModelTable::class,
            LaptopTable::class,
            OptionTable::class,
            LaptopOptionTable::class
        ];

        foreach ($models as $model) {
            if (!$connection->isTableExists(tableName: $model::getTableName())) {
                $model::getEntity()->createDbTable();
            }
        }

        return true;
    }


    /**
     * @throws SqlQueryException
     * @throws LoaderException
     * @throws SystemException
     */
    public function UnInstallDB(): bool
    {
        Loader::includeModule(moduleName: $this->MODULE_ID);

        $connection = Application::getConnection();

        $tables = [
            ManufacturerTable::class,
            ModelTable::class,
            LaptopTable::class,
            OptionTable::class,
            LaptopOptionTable::class
        ];

        foreach ($tables as $table) {
            if ($connection->isTableExists(tableName: $table::getTableName())) {
                $connection->dropTable(tableName: $table::getTableName());
            }
        }

        return true;
    }

    public function InstallFiles(): bool
    {
        try {
            $path = $_SERVER['DOCUMENT_ROOT'] . '/local/modules/ibs.laptops/components';
            if (Directory::isDirectoryExists(path: $path)) {
                $destination = $_SERVER['DOCUMENT_ROOT'] . '/local/components/ibs.laptops/';
                if (!CopyDirFiles(path_from: $path, path_to:  $destination, ReWrite: true, Recursive: true)) {
                    AddMessage2Log(text: Loc::getMessage(code: 'IBS_LAPTOPS_COPY_COMPONENT_FAIL'), module: $this->MODULE_ID);
                }
            } else {
                throw new InvalidPathException(path: $path);
            }
        } catch (Exception $e) {
            AddMessage2Log(text: 'Error: ' . $e->getMessage(), module: $this->MODULE_ID);
        }
        return true;
    }

    public function UnInstallFiles(): bool
    {
        return true;
    }

    /**
     * @throws LoaderException
     * @throws SqlQueryException
     * @throws SystemException
     */
    public function DoInstall(): bool
    {
        global $APPLICATION;

        $request = Context::getCurrent()?->getRequest();

        if ($request['step'] < 2) {
            $APPLICATION->IncludeAdminFile(
                strTitle: Loc::getMessage(code: 'IBS_LAPTOPS_INSTALL_MESSAGE'),
                filepath: __DIR__ . '/step1.php'
            );
        } else {
            ModuleManager::registerModule(moduleName: $this->MODULE_ID);

            if ($request['drop_tables'] === 'Y') {
                $this->UnInstallDB();
                Loader::includeModule(moduleName: $this->MODULE_ID);
                $this->InstallDB();
                DatabaseSeeder::seed();
            } else {
                $this->InstallDB();
            }

            $this->InstallFiles();

            $APPLICATION->IncludeAdminFile(
                strTitle: Loc::getMessage(code: 'IBS_LAPTOPS_INSTALL_SUCCESS'),
                filepath: __DIR__ . '/step2.php'
            );
        }

        return true;
    }

    /**
     * @throws SqlQueryException
     * @throws LoaderException
     * @throws SystemException
     */
    public function DoUninstall(): bool
    {
        global $APPLICATION;

        $request = Context::getCurrent()?->getRequest();

        if ($request['step'] < 2) {
            $APPLICATION->IncludeAdminFile(
                strTitle: Loc::getMessage(code: 'IBS_LAPTOPS_UNINSTALL_TITLE'),
                filepath: __DIR__ . '/unstep1.php'
            );
        } elseif ((int) $request['step'] === 2) {
            if($request['savedata'] === 'N') {
                $this->UnInstallDB();
            }
            ModuleManager::unRegisterModule(moduleName: $this->MODULE_ID);
            $APPLICATION->IncludeAdminFile(
                strTitle: Loc::getMessage(code: 'IBS_LAPTOPS_UNINSTALL_TITLE'),
                filepath: __DIR__ . '/unstep2.php'
            );
        }

        return true;
    }
}