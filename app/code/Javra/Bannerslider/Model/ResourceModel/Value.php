<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/5/18
 * Time: 10:58 AM
 */

namespace Javra\Bannerslider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Value extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('javra_bannerslider_value', 'value_id');
    }

}