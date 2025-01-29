<?php

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 */
?>

<div class="row p-2">
    <h3 class="w-100"> <?= Loc::getMessage(code: 'IBS_LAPTOP_MODEL_LIST') .  htmlspecialchars($arResult['MANUFACTURER']) ?>:</h3>
    <?php
    if (!empty($arResult['DATA'])): ?>
        <?php foreach ($arResult['DATA'] as $model): ?>
            <div class="col-md-4 mb-4">
                <a href="<?= $arParams['SEF_FOLDER'] . $arResult['VARIABLES']['MANUFACTURER'] . '/' . $model['ID'] . '/' ?>"
                   class="list-link text-primary text-decoration-none">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $model['TITLE'] ?></h5>
                            <p class="card-text">  <?= Loc::getMessage(code: 'IBS_LAPTOP_VIEW') ?> </p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach;
    else: ?>
        <p>  <?= Loc::getMessage(code: 'IBS_LAPTOP_MODELS_NOT_FOUND') ?> </p>
    <?php
    endif; ?>
</div>
