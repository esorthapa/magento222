<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/17/18
 * Time: 12:57 PM
 */

namespace Javra\Bannerslider\Block\Adminhtml;


class Report extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Report constructor.
     */

    protected function _construct()
    {
        $this->_controller = 'adminhtml_report';
        $this->_blockGroup = 'Javra_Bannerslider';
        $this->_headText = __('Reports');
        $this->_addButtonLabel = __('Add Report');
        parent::_construct();
        $this->removeButton('add');
    }

}