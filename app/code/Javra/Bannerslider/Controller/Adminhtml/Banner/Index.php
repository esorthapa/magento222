<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/16/18
 * Time: 10:30 AM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Banner;

use Javra\Bannerslider\Controller\Adminhtml\Banner;
class Index extends Banner
{
    /**
     * @return \Magento\Backend\Model\View\Result\Forward|
     * \Magento\Framework\App\ResponseInterface|
     * \Magento\Framework\Controller\ResultInterface|
     * \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if($this->getRequest()->getQuery('ajax'))
        {
            $resultForward = $this->_resultForwardFactory->create();
            $resultForward->forward('grid');

            return $resultForward;
        }
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }

}