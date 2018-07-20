<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/4/18
 * Time: 1:03 PM
 */

namespace Javra\Bannerslider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Slider extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('javra_bannerslider_slider', 'slider_id');

    }

}