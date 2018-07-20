<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/3/18
 * Time: 4:03 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml;

use Javra\Bannerslider\Controller\Adminhtml\AbstractAction;
abstract class Report extends AbstractAction
{
    /**
     * check if admin has permission to access to visit related pages.
     */

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Javra_Bannerslider::bannerslider_reports');

    }


}