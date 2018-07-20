<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/5/18
 * Time: 11:26 AM
 */

namespace Javra\Bannerslider\Model;

use Magento\Framework\Model\AbstractModel;

class Value extends AbstractModel
{
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Javra\Bannerslider\Model\ResourceModel\Value $resource,
        \Javra\Bannerslider\Model\ResourceModel\Value\Collection $resourceCollection
    )
    {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );

    }

    public function loadAttributeValue($bannerId, $storeViewId, $attributeCode)
    {
        $attributeValue = $this->getResourceCollection()
            ->addFieldToFilter('banner_id', $bannerId)
            ->addFieldToFilter('store_id', $storeViewId)
            ->addFieldToFilter('attribute_code', array('in' => $attributeCode));
//            ->setPageSize(1)->setCurPage(1)
//            ->getFirstItem();
        foreach($attributeValue as $model){
            $this->setData('banner_id', $bannerId)
                ->setData('store_id', $storeViewId)
                ->setData('attribute_code', $model->getData('attribute_code'));
            if ($model->getId()) {
                $this->addData($model->getData())
                    ->setId($model->getId());
            }
        }

        return $attributeValue;
    }

}