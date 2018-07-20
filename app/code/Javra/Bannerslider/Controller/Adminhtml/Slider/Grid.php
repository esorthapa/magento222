<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/4/18
 * Time: 11:49 AM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Slider;

use Javra\Bannerslider\Controller\Adminhtml\Slider;

class Grid extends Slider
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */

    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        return $resultLayout;
    }
}