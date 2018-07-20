<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/4/18
 * Time: 11:56 AM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Slider;

use Javra\Bannerslider\Controller\Adminhtml\Slider;

class NewAction extends Slider
{
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    public function execute()
    {
        $resultForward = $this->_resultForwardFactory->create();
        return $resultForward->forward('edit');
    }

}