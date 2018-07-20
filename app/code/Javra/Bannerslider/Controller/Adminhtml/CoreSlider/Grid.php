<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 3:44 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\CoreSlider;


class Grid extends \Javra\Bannerslider\Controller\Adminhtml\CoreSlider
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|
     * \Magento\Framework\Controller\ResultInterface|
     * \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();

        return $resultLayout;
    }

}