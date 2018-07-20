<?php
/**
 * This Module is generate number of count which like by user.
 * Copyright (C) 2017 www.javra.com 
 * 
 * This file is part of Javra/Viewcount.
 * 
 * Javra/Viewcount is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Javra\Viewcount\Controller\Adminhtml\Count;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('count_id');
        
            $model = $this->_objectManager->create('Javra\Viewcount\Model\Count')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Count no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Count.'));
                $this->dataPersistor->clear('javra_viewcount_count');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['count_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Count.'));
            }
        
            $this->dataPersistor->set('javra_viewcount_count', $data);
            return $resultRedirect->setPath('*/*/edit', ['count_id' => $this->getRequest()->getParam('count_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
