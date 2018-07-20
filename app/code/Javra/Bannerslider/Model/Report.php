<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/4/18
 * Time: 1:19 PM
 */

namespace Javra\Bannerslider\Model;

use Magento\Framework\Model\AbstractModel;

class Report extends AbstractModel
{
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Javra\Bannerslider\Model\ResourceModel\Report $resource,
        \Javra\Bannerslider\Model\ResourceModel\Report\Collection $resourceCollection
    )
    {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );

    }

}