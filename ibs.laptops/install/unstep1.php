<?php

declare(strict_types=1);

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}

Loc::loadMessages(file: __FILE__);
?>

<form action="<?= $APPLICATION->GetCurPage()?>">
<?=bitrix_sessid_post()?>
	<input type="hidden" name="lang" value="<?= LANGUAGE_ID?>">
	<input type="hidden" name="id" value="ibs.laptops">
	<input type="hidden" name="uninstall" value="Y">
	<input type="hidden" name="step" value="2">
	<?php CAdminMessage::ShowMessage(message: Loc::getMessage(code: 'MOD_UNINST_WARN'))?>
	<p><?= Loc::getMessage(code: 'MOD_UNINST_SAVE')?></p>
	<p><input type="checkbox" name="savedata" id="savedata" value="Y" checked><label for="savedata"><?= Loc::getMessage(code: 'MOD_UNINST_SAVE_TABLES')?></label></p>
	<input type="submit" name="" value="<?= Loc::getMessage(code: 'IBS_LAPTOPS_UNINSTALL_MODULE')?>">
</form>