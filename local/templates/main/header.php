<?php
/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */
?>
<!doctype html>
<html lang="<?= LANGUAGE_ID ?>">
<head>
    <meta charset="UTF-8" />

    <title><?php $APPLICATION->ShowTitle() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <?php $APPLICATION->ShowHead() ?>

    <?php $assetManager = Local\Utils\Assets::init(); ?>

    <?php $assetManager->renderAssetTag('/resources/styles/main.scss') ?>
</head>
<body class="page page_<?= LANGUAGE_ID ?> page_<?php $APPLICATION->ShowProperty('page_type', 'secondary') ?>">
    <?php $APPLICATION->ShowPanel() ?>

    <div class="page__top">
        <header class="header">
            <div class="header__inner">

                <div class="header__logo">
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/__include__/logo.php"
                        )
                    ); ?>
                </div>

                <div class="header__nav">
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "top",
                        array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "top",
                            "USE_EXT" => "N",
                        ),
                        false
                    ); ?>
                </div>
            </div>
        </header>

        <main class="page__middle">

            <section class="page__content">
                <?php if ($APPLICATION->GetCurPage(false) !== SITE_DIR) : ?>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "",
                    array(
                        "PATH" => "",
                        "SITE_ID" => "s1",
                        "START_FROM" => "0"
                    )
                ); ?>
                <h1 class="page__title"><?php $APPLICATION->ShowTitle(false) ?></h1>
<?php endif; ?>
