<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (empty($arResult['ITEMS'])): ?>
    <p>Данные не найдены.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <?php foreach ($arResult['COLUMNS'] as $col): ?>
                    <th><?= htmlspecialcharsbx($col) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($arResult['ITEMS'] as $item): ?>
                <tr>
                    <?php foreach ($arResult['COLUMNS'] as $col): ?>
                        <td><?= htmlspecialcharsbx($item[$col] ?? '') ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 15px;">
        <?= $arResult['NAV_STRING'] ?>
    </div>
<?php endif; ?>