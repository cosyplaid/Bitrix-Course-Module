<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application;
use Bitrix\Main\UI\PageNavigation;
use Currency\Course\CoursesTable; // ORM-сущность вашего модуля

if (!\Bitrix\Main\Loader::includeModule('currency.course')) {
    ShowError('Модуль currency.course не установлен');
    return;
}

$request = Application::getInstance()->getContext()->getRequest();

// вместо $request = …, смотрим только arParams:
$filterParams = $arParams['FILTER'];

// строим $filter[] из $filterParams
if (!empty($filterParams['DATE_FROM']))
    $filter['>=DATE'] = new \Bitrix\Main\Type\DateTime($filterParams['DATE_FROM']);

// Параметры компонента с дефолтами
$arParams['FILTER'] = $arParams['FILTER'] ?? [];
$arParams['COLUMNS'] = $arParams['COLUMNS'] ?? ['ID', 'CODE', 'DATE', 'COURSE'];
$arParams['PAGE_SIZE'] = (int)($arParams['PAGE_SIZE'] ?? 10);

// Инициализация навигации
$nav = new PageNavigation("page");
$nav->allowAllRecords(false)->setPageSize($arParams['PAGE_SIZE'])->initFromUri();

// Формируем фильтр из параметров компонента и из GET (если передан)
$filter = [];

// Фильтр из параметров компонента (например, из компонента filter)
if (!empty($arParams['FILTER']))
{
    if (!empty($arParams['FILTER']['DATE_FROM']))
        $filter['>=DATE'] = new \Bitrix\Main\Type\DateTime($arParams['FILTER']['DATE_FROM']);
    if (!empty($arParams['FILTER']['DATE_TO']))
        $filter['<=DATE'] = new \Bitrix\Main\Type\DateTime($arParams['FILTER']['DATE_TO']);
    if (!empty($arParams['FILTER']['COURSE_FROM']))
        $filter['>=COURSE'] = (float)$arParams['FILTER']['COURSE_FROM'];
    if (!empty($arParams['FILTER']['COURSE_TO']))
        $filter['<=COURSE'] = (float)$arParams['FILTER']['COURSE_TO'];
    if (!empty($arParams['FILTER']['CODE']))
        $filter['=CODE'] = $arParams['FILTER']['CODE'];
}

// Получаем общее количество записей
$total = CoursesTable::getCount($filter);
$nav->setRecordCount($total);

// Получаем данные с учетом навигации
$rsData = CoursesTable::getList([
    'select' => $arParams['COLUMNS'],
    'filter' => $filter,
    'order' => ['DATE' => 'DESC'],
    'limit' => $nav->getLimit(),
    'offset' => $nav->getOffset(),
]);

$arResult['ITEMS'] = [];
while ($item = $rsData->fetch())
{
    if (isset($item['DATE']) && $item['DATE'] instanceof \Bitrix\Main\Type\DateTime)
    {
        $item['DATE'] = $item['DATE']->format('Y-m-d');
    }
    $arResult['ITEMS'][] = $item;
}

$arResult['NAV_OBJECT'] = $nav;

$arResult['COLUMNS'] = $arParams['COLUMNS'];
$arResult['FILTER'] = $arParams['FILTER'];

$this->includeComponentTemplate();