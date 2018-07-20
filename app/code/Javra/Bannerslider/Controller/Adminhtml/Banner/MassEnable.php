<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 1:01 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Banner;

use Magento\Framework\Controller\ResultFactory;
use Javra\Bannerslider\Model\ResourceModel\Banner\Grid\StatusesArray;

class MassEnable extends \Javra\Bannerslider\Controller\Adminhtml\AbstractAction
{
    public function execute()
    {
        $collection = $this->_massActionFilter->getCollection($this->_createMainCollection());
        $collectionSize = $collection->getSize();
        $storeId = $this->getRequest()->getParam('store');
        $collection->setStoreViewId($storeId);
        foreach ($collection as $item){
            $item->setStoreViewId($storeId);
            $item->setStatus(StatusesArray::STATUS_ENABLED);
            try{
                $item->save();
            }catch (\Exception $e){
                $this->messageManager->addError($e->getMessage());
            }
        }
        $this->messageManager->addSuccess(__('A total of 1% record(s) have been Enabled.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }

}