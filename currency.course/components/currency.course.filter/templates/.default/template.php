<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<form method="get" action="<?= htmlspecialcharsbx($APPLICATION->GetCurPage()) ?>">
    <div>
        <label>Дата с:</label>
        <input type="date" name="DATE_FROM" value="<?= htmlspecialcharsbx($arResult['FILTER']['DATE_FROM']) ?>">
    </div>
    <div>
        <label>Дата по:</label>
        <input type="date" name="DATE_TO" value="<?= htmlspecialcharsbx($arResult['FILTER']['DATE_TO']) ?>">
    </div>
    <div>
        <label>Курс от:</label>
        <input type="number" step="0.0001" name="COURSE_FROM" value="<?= htmlspecialcharsbx($arResult['FILTER']['COURSE_FROM']) ?>">
    </div>
    <div>
        <label>Курс до:</label>
        <input type="number" step="0.0001" name="COURSE_TO" value="<?= htmlspecialcharsbx($arResult['FILTER']['COURSE_TO']) ?>">
    </div>
    <div>
        <label>Код валюты:</label>
        <input type="text" name="CODE" value="<?= htmlspecialcharsbx($arResult['FILTER']['CODE']) ?>"
               maxlength="3" style="text-transform: uppercase;">
    </div>
    <div>
        <input type="submit" value="Фильтровать">
        <input type="reset" onclick="window.location='<?= htmlspecialcharsbx($APPLICATION->GetCurPage()) ?>';"
               value="Сбросить">
    </div>
</form>
