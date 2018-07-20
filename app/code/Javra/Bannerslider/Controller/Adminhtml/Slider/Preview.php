<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 12:58 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Slider;


class Preview extends \Javra\Bannerslider\Controller\Adminhtml\Slider
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        return $resultPage;
    }
}