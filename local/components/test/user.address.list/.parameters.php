<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var array $arCurrentValues */

use Bitrix\Main\Localization\Loc;

$arComponentParameters = [
    'GROUPS' => [],
    'PARAMETERS' => [
        'ACTIVE' => [
            'NAME' => Loc::getMessage('TEST_USER_ADDRESSES_ACTIVE'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N',
        ]
    ],
];