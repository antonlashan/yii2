<?php

/**
 * Description of Helper
 *
 * @author Lashan
 */

namespace common\components;

class Helper {

    public static function getDaysBetweenDates($_from, $_to)
    {
        $datetime1 = date_create($_from);
        $datetime2 = date_create($_to);
        return date_diff($datetime1, $datetime2);
    }

}
