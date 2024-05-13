<?php

use Bitrix\Main\{
    Application,
    Loader,
    SystemException,
    Data\Cache,
    Localization\Loc,
    Engine\CurrentUser
};
use Bitrix\Highloadblock\HighloadBlockTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class UserAddressesComponent extends CBitrixComponent
{
    protected int $userId;

    /**
     * Checks if necessary modules are loaded.
     *
     * @throws SystemException
     */
    protected function checkModules(): void
    {
        if (!Loader::includeModule('highloadblock')) {
            throw new SystemException(Loc::getMessage('HIGLOADBLOCK_MODULE_NOT_INSTALLED'));
        }
    }

    /**
     * Prepares and validates component parameters.
     *
     * @param array $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams['ACTIVE'] = $arParams['ACTIVE'] ?? 'N';
        $arParams['CACHE_TIME'] = $arParams['CACHE_TIME'] ?? 3600;
        return $arParams;
    }

    /**
     * Initializes component properties.
     *
     * @return void
     */
    protected function setupProperties(): void
    {
        $this->userId = CurrentUser::get()->getId();
    }

    /**
     * Fetches and caches the addresses from the highloadblock.
     *
     * @return void
     */
    protected function getResult(): void
    {
        $cache = Cache::createInstance();
        $taggedCache = Application::getInstance()->getTaggedCache();
        $cacheKey = 'addresses_list_' . $this->userId . ($this->arParams['ACTIVE'] == 'Y' ? '_active' : '');
        $cachePath = '/addresses';
        if ($cache->initCache($this->arParams['CACHE_TIME'], $cacheKey, $cachePath)) {
            $this->arResult = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            $hlblockId = $this->arParams['HL_BLOCK_ID'];
            $taggedCache->startTagCache($cachePath);
            $taggedCache->registerTag("highloadblock_id_{$hlblockId}");

            $addresses = [];
            $hlblock = HighloadBlockTable::getById($hlblockId)->fetch();
            $entity = HighloadBlockTable::compileEntity($hlblock);
            $entityClass = $entity->getDataClass();
            $filter = ['UF_USER_ID' => $this->userId];
            if ($this->arParams['ACTIVE'] == 'Y') {
                $filter['UF_ACTIVE'] = true;
            }
            $results = $entityClass::getList([
                'select' => ['UF_ADDRESS', 'ID'],
                'filter' => $filter
            ]);

            foreach ($results as $result) {
                $addresses[] = [
                    'data' => [
                        'ID' => $result['ID'],
                        'ADDRESS' => $result['UF_ADDRESS']
                    ]
                ];
            }

            $this->arResult['ADDRESSES'] = $addresses;
            $taggedCache->endTagCache();
            $cache->endDataCache($this->arResult);
        }
    }

    /**
     * Main method to execute the component logic.
     *
     * @return void
     */
    public function executeComponent(): void
    {
        try {
            $this->checkModules();
            $this->setupProperties();
            $this->getResult();
            $this->includeComponentTemplate();
        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }
}