<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/16/18
 * Time: 11:19 AM
 */

namespace Javra\Bannerslider\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;
class Slider extends  Container
{

    /**
     * Slider constructor.
     */

    protected function _construct()
    {
        $this->_controller = 'adminhtml_slider';
        $this->_blockGroup = 'Javra_Bannerslider';
        $this->_headText = __('Slider');
        $this->_addButtonLabel = __('Add Slider');
        parent::_construct();
    }

}