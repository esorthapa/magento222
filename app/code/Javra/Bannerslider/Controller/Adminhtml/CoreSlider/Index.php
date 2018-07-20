<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/16/18
 * Time: 10:34 AM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\CoreSlider;


class Index extends \Javra\Bannerslider\Controller\Adminhtml\CoreSlider
{
    /**
     * @return \Magento\Backend\Model\View\Result\Forward|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if($this->getRequest()->getQuery('ajax'))
        {
            $resultForward = $this->_resultForwardFactory->create();
            $resultForward->forward('grid');

            return $resultForward;
        }
        $resultPage = $this->_resultForwardFactory->create();
        return $resultPage;
    }

}