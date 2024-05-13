<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\{
    Application,
    EventManager,
    Entity\Event,
};

const ADDRESSES_HLBLOCK_ID = 2; // ID Highloadblock-таблицы с адресами пользователя

$eventManager = EventManager::getInstance();

/* Обработка событий модификации данных HighloadBlock 'UserAddresses' */
function ResetHLUserAddressesCache(Event $event): void
{
    $event->getEntity()->cleanCache();

    $taggedCache = Application::getInstance()->getTaggedCache();
    $taggedCache->clearByTag('highloadblock_id_'.ADDRESSES_HLBLOCK_ID);
}
$eventManager->addEventHandler('', 'UserAddressesOnAfterAdd', 'ResetHLUserAddressesCache');
$eventManager->addEventHandler('', 'UserAddressesOnAfterUpdate', 'ResetHLUserAddressesCache');
$eventManager->addEventHandler('', 'UserAddressesOnAfterDelete', 'ResetHLUserAddressesCache');