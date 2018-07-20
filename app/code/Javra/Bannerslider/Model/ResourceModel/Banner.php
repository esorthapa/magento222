<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/5/18
 * Time: 10:52 AM
 */

namespace Javra\Bannerslider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Banner extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('javra_bannerslider_banner', 'banner_id');
    }

}