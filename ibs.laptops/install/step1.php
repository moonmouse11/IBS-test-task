<?php

declare(strict_types=1);

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}

Loc::loadMessages(file: __FILE__);
?>

<form action="<?= $APPLICATION->GetCurPage() ?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="id" value="ibs.laptops">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID?>">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">
    <?= Loc::getMessage(code: 'IBS_LAPTOPS_INSTALL_MESSAGE') ?>
    <p>
        <input type="checkbox" name="drop_tables" id="drop_tables" value="Y" checked>
        <label for="drop_tables"> <?= Loc::getMessage(code: 'IBS_LAPTOPS_INSTALL_OPTION') ?> </label>
    </p>
    <input type="submit" name="" value="<?= Loc::getMessage(code: 'SHOP_LAPTOPS_INSTALL_MODULE') ?>">
</form>