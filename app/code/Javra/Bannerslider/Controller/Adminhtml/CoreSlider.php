<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/3/18
 * Time: 4:06 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml;

use Javra\Bannerslider\Controller\Adminhtml\AbstractAction;
abstract class CoreSlider extends AbstractAction
{
    /**
     * check if admin has permission access to visit related pages.
     */

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Javra_Bannerslider::bannerslider_coreslider');
    }
}