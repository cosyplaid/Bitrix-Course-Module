<?php
use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(
    "currency.course",
    [
        "Currency\\Course\\CoursesTable" => "lib/coursestable.php",
    ]
);