<?php
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

class currency_course extends CModule
{
    public $MODULE_ID = "currency.course";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME = "Курсы валют";
    public $MODULE_DESCRIPTION = "Модуль для хранения курсов валют с фильтром и списком";
    public $PARTNER_NAME = "Валентин";

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . "/version.php";
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
    }

    public function DoInstall()
    {
        global $APPLICATION;

        $this->InstallDB();
        $this->InstallFiles();
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        global $APPLICATION;

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $this->UnInstallDB();
        $this->UnInstallFiles();
    }

    public function InstallDB()
    {
        $connection = Application::getConnection();
        $sqlHelper = $connection->getSqlHelper();

        if (!$connection->isTableExists('b_currency_course'))
        {
            // Создаём таблицу, если не существует
            $connection->queryExecute("
                CREATE TABLE b_currency_course (
                    ID INT(11) NOT NULL AUTO_INCREMENT,
                    CODE VARCHAR(3) NOT NULL DEFAULT 'USD',
                    DATE DATETIME NOT NULL,
                    COURSE FLOAT NOT NULL DEFAULT 70,
                    PRIMARY KEY (ID)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8
            ");

            // Вставляем тестовые данные
            $connection->queryExecute("
                INSERT INTO b_currency_course (CODE, DATE, COURSE) VALUES
                    ('USD', '2025-01-30 00:00:00', 98.01),
                    ('USD', '2025-02-28 00:00:00', 87.69),
                    ('USD', '2025-03-29 00:00:00', 83.68),
                    ('USD', '2025-04-30 00:00:00', 81.56),
                    ('USD', '2025-05-31 00:00:00', 78.62),
                    ('USD', '2025-06-28 00:00:00', 78.46),
                    ('USD', '2025-07-31 00:00:00', 81.83),
                    ('USD', '2025-08-30 00:00:00', 80.33),
                    ('USD', '2025-09-06 00:00:00', 81.55),
                    ('EUR', '2025-01-30 00:00:00', 102.41),
                    ('EUR', '2025-02-28 00:00:00', 92.04),
                    ('EUR', '2025-03-29 00:00:00', 89.66),
                    ('EUR', '2025-04-30 00:00:00', 93.17),
                    ('EUR', '2025-05-31 00:00:00', 89.25),
                    ('EUR', '2025-06-28 00:00:00', 92.28),
                    ('EUR', '2025-07-31 00:00:00', 94.95),
                    ('EUR', '2025-08-30 00:00:00', 94.05),
                    ('EUR', '2025-09-06 00:00:00', 95.48)
            ");
        }
    }

    public function UnInstallDB()
    {
        $connection = Application::getConnection();
        if ($connection->isTableExists('b_currency_course'))
        {
            $connection->queryExecute("DROP TABLE b_currency_course");
        }
    }

    public function InstallFiles()
    {
        // Копируем компоненты в local/components/currency.course/
        CopyDirFiles(__DIR__ . "/../components/currency.course.filter", $_SERVER["DOCUMENT_ROOT"] . "/local/components/currency.course/filter", true, true);
        CopyDirFiles(__DIR__ . "/../components/currency.course.list", $_SERVER["DOCUMENT_ROOT"] . "/local/components/currency.course/list", true, true);
    }

    public function UnInstallFiles()
    {
        // Удаляем компоненты
        DeleteDirFilesEx("/local/components/currency.course/filter");
        DeleteDirFilesEx("/local/components/currency.course/list");
    }
}