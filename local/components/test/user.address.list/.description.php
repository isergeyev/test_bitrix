<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    'NAME' => Loc::getMessage('TEST_USER_ADDRESSES_NAME'),
    'DESCRIPTION' => Loc::getMessage('TEST_USER_ADDRESSES_DESCRIPTION'),
    'SORT' => 10,
    'CACHE_PATH' => 'Y',
    'PATH' => [
        'ID' => Loc::getMessage('TEST_COMPONENTS_GROUP_NAME'),
    ],
    'COMPLEX' => 'N',
];