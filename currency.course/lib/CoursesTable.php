<?php
namespace Currency\Course;

use Bitrix\Main\Entity;
use Bitrix\Main\Type\DateTime;

class CoursesTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_currency_course';
    }

    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
            ]),
            new Entity\StringField('CODE', [
                'required' => true,
                'validation' => function() {
                    return [
                        new Entity\Validator\Length(null, 3),
                    ];
                }
            ]),
            new Entity\DatetimeField('DATE', [
                'required' => true,
            ]),
            new Entity\FloatField('COURSE', [
                'required' => true,
            ]),
        ];
    }
}