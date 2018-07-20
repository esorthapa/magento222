<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/17/18
 * Time: 12:59 PM
 */

namespace Javra\Bannerslider\Block\Adminhtml;


class CoreSlider extends \Magento\Backend\Block\Widget\Grid\Container
{

    protected function _construct()
    {
        $this->_controller = 'adminhtml_slider';
        $this->_blockGroup = 'Javra_Bannerslider';
        $this->_headText = __('Preview');
        $this->_addButtonLabel = __('Add New Slider');
        parent::_construct();
    }
}