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
                    ('USD', '2025-09-01 00:00:00', 75.50),
                    ('EUR', '2025-09-01 00:00:00', 85.30)
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