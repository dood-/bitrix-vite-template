<?php
/** @var \CMain $APPLICATION */
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Главная страница");
$APPLICATION->SetPageProperty("page_type", "main");
?>

<h1>Site</h1>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
