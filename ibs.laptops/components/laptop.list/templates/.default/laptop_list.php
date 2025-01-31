<?php

if (!defined(constant_name: 'B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

/**
 * @var array $arResult
 * @var array $arParams
 * @var string $componentPath
 * @var string $templateFolder
 * @var string $componentName
 * @global CMain $APPLICATION
 */

?>

<form method="GET" class="mb-4 p-2 border">
    <div class="row g-3 mb-2">
        <div class="col-12 col-md-4 text-center">
            <label for="sort_by" class="mb-2"> <?= Loc::getMessage(code: 'IBS_LAPTOP_FORM_SORTED') ?> :</label>
            <select name="sort_by" id="sort_by" class="form-control">
                <option value="PRICE" <?= ($arResult['REQUEST']->getQuery('sort_by') === 'PRICE') ? 'selected' : '' ?>> <?= Loc::getMessage(code: 'IBS_LAPTOP_FORM_PRICE') ?> </option>
                <option value="YEAR" <?= ($arResult['REQUEST']->getQuery('sort_by') === 'YEAR') ? 'selected' : '' ?>> <?= Loc::getMessage(code: 'IBS_LAPTOP_FORM_YEAR') ?> </option>
            </select>
        </div>
        <div class="col-12 col-md-4 text-center">
            <label for="sort_order" class="mb-2"> <?= Loc::getMessage(code: 'IBS_LAPTOP_FORM_ORDER') ?> :</label>
            <select name="sort_order" id="sort_order" class="form-control">
                <option value="ASC" <?= ($arResult['REQUEST']->getQuery('sort_order') === 'ASC') ? 'selected' : '' ?>> <?= Loc::getMessage(code: 'IBS_LAPTOP_FORM_SORT_BY_ASC') ?> </option>
                <option value="DESC" <?= ($arResult['REQUEST']->getQuery('sort_order') === 'DESC') ? 'selected' : '' ?>> <?= Loc::getMessage(code: 'IBS_LAPTOP_FORM_SORT_BY_DESC') ?></option>
            </select>
        </div>
        <div class="col-12 col-md-4 text-center">
            <label for="page_size" class="mb-2"> <?= Loc::getMessage(code: 'IBS_LAPTOP_FORM_PER_PAGE') ?> :</label>
            <select name="page_size" id="page_size" class="form-control">
                <option value="5" <?= ($arResult['REQUEST']->getQuery('page_size') === '5') ? 'selected' : '' ?>>5</option>
                <option value="10" <?= ($arResult['REQUEST']->getQuery('page_size') === '10') ? 'selected' : '' ?>>10</option>
                <option value="20" <?= ($arResult['REQUEST']->getQuery('page_size') === '20') ? 'selected' : '' ?>>20</option>
            </select>
        </div>
    </div>
    <div class="d-flex flex-column align-self-stretch w-100">
        <button type="submit" class="btn btn-primary h-100 w-100"><?= Loc::getMessage(code: 'IBS_LAPTOP_FORM_APPLY') ?> </button>
    </div>
</form>

<h3 class="w-100"> <?= Loc::getMessage(code: 'IBS_LAPTOP_LIST') . htmlspecialchars($arResult['MODEL']) ?>:</h3>
<div class="row p-2">
    <?php if (!empty($arResult['DATA'])): ?>
        <?php foreach ($arResult['DATA'] as $laptop): ?>
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <a href="<?= $arParams['SEF_FOLDER'] ?>detail/<?= $laptop['ID'] ?>/" class="list-link text-decoration-none text-dark">
                    <div class="card h-100">
                        <img src="<?= $templateFolder . $laptop['LIST_IMAGE'] ?>" alt="PreviewImage" class="card-img-top img-fluid notebook-image">

                        <div class="card-body text-center">
                            <h6 class="card-title"><?= $laptop['TITLE'] ?></h6>
                            <h6 class="card-subtitle mb-2 text-muted"> <?= Loc::getMessage(code: 'IBS_LAPTOP_RELEASE_YEAR')?> : <?= $laptop['YEAR'] ?></h6>
                            <p class="card-text"> <?= Loc::getMessage(code: 'IBS_LAPTOP_RELEASE_PRICE_NAME')?> : <?= $laptop['PRICE'] . ' ' .  Loc::getMessage(code: 'IBS_LAPTOP_RELEASE_CURRENCY') ?>  </p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p><?= Loc::getMessage(code: 'IBS_LAPTOP_MODELS_NOT_FOUND') ?></p>
    <?php endif; ?>
</div>

<?php

$APPLICATION->IncludeComponent(
    componentName: 'bitrix:main.pagenavigation',
    componentTemplate: '',
    arParams: [
        'NAV_OBJECT' => $arResult['NAV_OBJECT'],
        'SEF_MODE' => 'N',
        'SHOW_ALWAYS' => 'Y',
        'TITLE' => 'Навигация по страницам',
        'AJAX_MODE' => 'N',
        'USE_PAGE_SIZE' => 'Y',
    ],
    parentComponent: ''
);


