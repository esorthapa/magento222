<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/17/18
 * Time: 11:30 AM
 */

namespace Javra\Bannerslider\Block\Adminhtml\Slider\Edit;


class Tabs extends \Magento\Backend\Block\Widget\Tab
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Slider Information'));
    }

}