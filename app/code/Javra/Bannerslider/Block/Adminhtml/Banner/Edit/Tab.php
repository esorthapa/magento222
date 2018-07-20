<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 11:49 AM
 */

namespace Javra\Bannerslider\Block\Adminhtml\Banner\Edit;


class Tab extends \Magento\Backend\Block\Widget\Tab
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('banner_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Banner Information'));
    }

}