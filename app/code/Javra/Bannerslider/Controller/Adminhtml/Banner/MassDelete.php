<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 1:00 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Banner;

use Magento\Framework\Controller\ResultFactory;
class MassDelete extends \Javra\Bannerslider\Controller\Adminhtml\AbstractAction
{
    public function execute()
    {
        $collection = $this->_massActionFilter->getCollection($this->_createMainCollection());

        $collectionSize = $collection->getSize();
        foreach ($collection as $banner){
            $banner->delete();
        }
        $this->messageManager->addSuccess(__('A totla of %1 records(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');

    }

}