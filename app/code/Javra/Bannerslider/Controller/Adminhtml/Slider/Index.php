<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/3/18
 * Time: 4:51 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Slider;

use Javra\Bannerslider\Controller\Adminhtml\Slider;
class Index extends Slider
{
    public function execute()
    {

        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->_resultForwardFactory->create();
            $resultForward->forward('grid');

            return $resultForward;
        }

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Javra_Bannerslider::main_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Slider'));

        return $resultPage;

    }

}