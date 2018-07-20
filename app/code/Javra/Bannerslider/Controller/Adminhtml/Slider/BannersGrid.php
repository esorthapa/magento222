<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 12:59 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Slider;


class BannersGrid extends \Javra\Bannerslider\Controller\Adminhtml\Slider
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('bannerslider.slider.edit.tab.banners')->setInBanner($this->getRequest()->getPost('banner',null));

        return $resultLayout;

    }

}