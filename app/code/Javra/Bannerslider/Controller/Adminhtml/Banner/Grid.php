<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/16/18
 * Time: 10:57 AM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Banner;


class Grid extends \Javra\Bannerslider\Controller\Adminhtml\Banner
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