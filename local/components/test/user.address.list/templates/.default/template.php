<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

if (empty($arResult['ADDRESSES']))
    return;

$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [
    'GRID_ID' => 'addresses_list',
    'COLUMNS' => [
        ['id' => 'ID', 'name' => '№', 'sort' => 'ID', 'default' => true],
        ['id' => 'ADDRESS', 'name' => 'Адрес', 'sort' => 'ADDRESS', 'default' => true],
    ],
    'ROWS' => $arResult['ADDRESSES'],
    'SHOW_TOTAL_COUNTER' => false,
    'SHOW_ROW_CHECKBOXES' => false,
    'SHOW_GRID_SETTINGS_MENU' => false,
    'ALLOW_SORT' => false,
]);
