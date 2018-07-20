<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/5/18
 * Time: 10:56 AM
 */

namespace Javra\Bannerslider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Report extends AbstractDb
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('javra_bannerslider_report', 'report_id');
    }

}