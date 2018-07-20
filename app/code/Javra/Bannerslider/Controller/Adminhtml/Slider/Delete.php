<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 12:58 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Slider;


class Delete extends \Javra\Bannerslider\Controller\Adminhtml\Slider
{
    public function execute()
    {
        $sliderId = $this->getRequest()->getParam(static::PARM_CRUD_ID);
        try {
            $slider = $this->_sliderFactory->create()->setId($sliderId);
            $slider->delete();
            $this->messageManager->addSuccess(
                __('Delete successfully !')
            );
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }

}