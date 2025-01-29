<?php

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

/**
 * @var array $arResult
 * @var string $templateFolder
 */

?>

<div class="container notebook-detail mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="text-light">  <?= Loc::getMessage(code: 'IBS_LAPTOP_ABOUT'). ' ' .$arResult['LAPTOP']['TITLE'] ?></h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-subtitle mb-3 text-muted"> <?= Loc::getMessage(code: 'IBS_LAPTOP_DETAIL') ?>: </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> <?= Loc::getMessage(code: 'IBS_LAPTOP_MANUFACTURER') ?> : <strong><?= $arResult['LAPTOP']['MANUFACTURER_TITLE'] ?></strong></li>
                        <li class="list-group-item"> <?= Loc::getMessage(code: 'IBS_LAPTOP_MODEL') ?> : <strong><?= $arResult['LAPTOP']['MODEL_TITLE'] ?></strong></li>
                        <li class="list-group-item"> <?= Loc::getMessage(code: 'IBS_LAPTOP_TITLE') ?> : <strong><?= $arResult['LAPTOP']['TITLE'] ?></strong></li>
                        <li class="list-group-item"> <?= Loc::getMessage(code: 'IBS_LAPTOP_YEAR') ?>: <strong><?= $arResult['LAPTOP']['YEAR'] ?></strong></li>
                        <li class="list-group-item"> <?= Loc::getMessage(code: 'IBS_LAPTOP_PRICE') ?> : <span class="badge bg-success"><?= $arResult['LAPTOP']['PRICE']. ' ' . Loc::getMessage(code: 'IBS_LAPTOP_CURRENCY') ?> </span></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="<?= $templateFolder.$arResult['LAPTOP']['DETAIL_IMAGE'] ?>" class="img-fluid" alt="laptop_image">
                </div>
            </div>
        </div>
    </div>

    <!-- Раздел с опциями -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-secondary text-white">
            <h2 class="card-title"> <?= Loc::getMessage(code: 'IBS_LAPTOP_OPTIONS_AVAILABLE') ?> </h2>
        </div>
        <div class="card-body">
            <?php if (!empty($arResult['OPTIONS'])): ?>
                <ul class="list-group">
                    <?php foreach ($arResult['OPTIONS'] as $option): ?>
                        <li class="list-group-item">
                            <i class="bi bi-check-circle-fill text-success me-2"></i><?= $option['OPTION_TITLE'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-warning"><i class="bi bi-exclamation-circle-fill"></i>  <?= Loc::getMessage(code: 'IBS_LAPTOP_OPTIONS_UNAVAILABLE') ?> </p>
            <?php endif; ?>
        </div>
    </div>
</div>
