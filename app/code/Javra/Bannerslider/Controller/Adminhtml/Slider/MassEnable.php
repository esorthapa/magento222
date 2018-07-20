<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/4/18
 * Time: 11:56 AM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Slider;


class MassEnable extends \Javra\Bannerslider\Controller\Adminhtml\AbstractAction
{
    public function execute()
    {
        $sliderCollection = $this->_objectManager->create('Javra\Bannerslider\Model\ResourceModel\Slider\Collection');
        $collection = $this->_massActionFilter->getCollection($sliderCollection);
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $item->setStatus(StatusesArray::STATUS_ENABLED);
            try{
                $item->save();

            }catch (\Exception $e){
                $this->messageManager->addError($e->getMessage());
            }
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been Enabled.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
        
    }

}