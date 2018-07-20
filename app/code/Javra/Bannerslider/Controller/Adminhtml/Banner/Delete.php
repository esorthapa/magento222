<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 1:00 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml\Banner;


class Delete extends \Javra\Bannerslider\Controller\Adminhtml\Banner
{
    public function execute()
    {
        $bannerId = $this->getRequest()->getParam(static::PARM_CRUD_ID);

        try{
            $banner = $this->_bannerFactory->create()->setId($bannerId);
            $banner->delete();

            $this->messageManager->addSuccess(
                __('Delete successfully !')
            );

        }catch (\Exception $e){
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }

}