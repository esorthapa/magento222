<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/5/18
 * Time: 11:42 AM
 */

namespace Javra\Bannerslider\Model;


class Status
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_ENABLE => __('Enable'),
            self::STATUS_DISABLE => __('Disable')
        ];
    }

}