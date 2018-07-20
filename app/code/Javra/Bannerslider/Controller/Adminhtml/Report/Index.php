<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/3/18
 * Time: 4:59 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Report;

use Javra\Bannerslider\Controller\Adminhtml\Report;
class Index extends Report
{

    /**
     * @return \Magento\Backend\Model\View\Result\Forward|
     * \Magento\Framework\App\ResponseInterface|
     * \Magento\Framework\Controller\ResultInterface|
     * \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->_resultForwardFactory->create();
            $resultForward->forward('grid');

            return $resultForward;
        }

        $resultPage = $this->_resultPageFactory->create();

        return $resultPage;

    }

}