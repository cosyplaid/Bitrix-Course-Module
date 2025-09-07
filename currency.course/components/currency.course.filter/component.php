<?php
namespace Currency\Course;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();

$arResult['FILTER'] = [
    'DATE_FROM'   => $request->get('DATE_FROM'),
    'DATE_TO'     => $request->get('DATE_TO'),
    'COURSE_FROM' => $request->get('COURSE_FROM'),
    'COURSE_TO'   => $request->get('COURSE_TO'),
    'CODE'        => $request->get('CODE'),
];

// Передаем фильтр в шаблон
$this->includeComponentTemplate();

return $arResult;