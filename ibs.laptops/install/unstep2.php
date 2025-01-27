<?php

declare(strict_types=1);

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); }

use \Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}

if ($ex = $APPLICATION->GetException()) {
    CAdminMessage::ShowMessage(
        message: [
            'TYPE' => 'ERROR',
            'MESSAGE' => Loc::getMessage(code: 'IBS_LAPTOPS_UNINSTALL_FAIL'),
            'DETAILS' => $ex->GetString(),
            'HTML' => true,
        ]
    );
} else {
    CAdminMessage::ShowNote(message: Loc::getMessage(code: 'IBS_LAPTOPS_UNINSTALL_SUCCESS'));
}
?>
<form action="<?= $APPLICATION->GetCurPage() ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?= Loc::getMessage(code: 'MOD_BACK') ?>">
</form>