<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 12/6/17
 * Time: 12:01 PM
 */

namespace Javra\Javraevents\Block\Adminhtml;

use \Magento\Backend\Block\Widget\Grid\Container;


class Post extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_post';
        $this->_blockGroup = 'Javra_Javraevents';
        $this->_headerText = __('Manage News & Posts');
        parent::_construct();
        if ($this->_isAllowedAction('Javra_Javraevents::save')) {
            $this->buttonList->update('add', 'label', __('Add New Post'));
        } else {
            $this->buttonList->remove('add');
        }
    }
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}