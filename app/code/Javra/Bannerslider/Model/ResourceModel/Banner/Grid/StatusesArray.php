<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/5/18
 * Time: 12:57 PM
 */

namespace Javra\Bannerslider\Model\ResourceModel\Banner\Grid;

use Magento\Framework\Option\ArrayInterface;
class StatusesArray implements ArrayInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_DISABLED => __('Disabled')
        ];
    }

}