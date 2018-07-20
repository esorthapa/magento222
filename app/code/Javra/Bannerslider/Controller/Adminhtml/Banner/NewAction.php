<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 1:01 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Banner;


class NewAction extends \Javra\Bannerslider\Controller\Adminhtml\Banner
{
    /**
     * @return \Magento\Backend\Model\View\Result\Forward|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultForward = $this->_resultForwardFactory->create();

        return $resultForward->forward('edit');

    }

}