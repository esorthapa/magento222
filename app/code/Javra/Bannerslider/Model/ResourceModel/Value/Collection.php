<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/4/18
 * Time: 1:20 PM
 */

namespace Javra\Bannerslider\Model\ResourceModel\Value;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('Javra\Bannerslider\Model\Value', 'Javra\Bannerslider\Model\ResourceModel\Value');
    }


}