<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 1:01 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Report;


class Grid extends \Javra\Bannerslider\Controller\Adminhtml\Report
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();

        return $resultLayout;
    }

}