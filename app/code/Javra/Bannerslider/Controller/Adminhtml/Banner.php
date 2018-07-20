<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/3/18
 * Time: 3:59 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml;

use Javra\Bannerslider\Controller\Adminhtml\AbstractAction;


abstract class Banner extends AbstractAction
{
    const PARM_CRUD_ID = 'banner_id';

    /**
     * check if admin has permission to access to visit related page.
     *
     */

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Javra_Bannerslider::bannerslider_banners');
    }



}