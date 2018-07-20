<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 1:00 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Banner;

use Magento\Framework\Controller\ResultFactory;
use Javra\Bannerslider\Model\ResourceModel\Banner\Grid\StatusesArray;


class MassDisable extends \Javra\Bannerslider\Controller\Adminhtml\AbstractAction
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $collection = $this->_massActionFilter->getCollection($this->_createMainCollection());
        $collectionSize = $collection->getSize();
        $storeId = $this->getRequest()->getParam('store');
        $collection->setStoreViewId($storeId);
        foreach ($collection as $item){
            $item->setStoreViewId($storeId);
            $item->setStatus(StatusesArray::STATUS_DISABLED);
            try{
                $item->save();

            }catch (\Exception $e){
                $this->messageManager->addError($e->getMessage());
            }
        }
        $this->messageManager->addSuccess(__('A total of 1% records have been disabled.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');

    }

}