<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 11/24/17
 * Time: 3:01 PM
 */

namespace Javra\Javraevents\Controller\Adminhtml\Post;

use \Magento\Backend\App\Action;
use \Magento\Framework\App\ObjectManager;
use \Magento\Framework\App\Filesystem\DirectoryList;
//use Magento\Store\Model\StoreManagerInterface;
//use Magento\Framework\UrlInterface;


class Save extends Action
{

    /**
     * @var \Magento\Framework\Image\AdapterFactory
     */
    protected $adapterFactory;
    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $uploader;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    protected $_fileUploaderFactory;

    protected $_storeManager;

    protected $storeManager;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */

    public function __construct(Action\Context $context

//                                UrlInterface $urlBuilder
//                                StoreManagerInterface $storeManager

    )
    {
      //  $this->storeManager = $storeManager;
//        $this->urlBuilder = $urlBuilder;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Javra_Javraevents::save');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
       
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('Javra\Javraevents\Model\Post');
            //Image check
             if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
               try {
                   $objectManager = ObjectManager::getInstance();
                   $fileSystem = $objectManager->create('\Magento\Framework\Filesystem');
                   $mediaPath = $fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
                   $media = $mediaPath.'showroom/';
                   
                   $file_name = rand() . $_FILES['image']['name'];
                   $file_size = $_FILES['image']['size'];
                   $file_tmp = $_FILES['image']['tmp_name'];
                   $file_type = $_FILES['image']['type'];
                   move_uploaded_file($file_tmp, $media . $file_name);

                  $base_media_path = 'showroom/';

                  $data['image']=$base_media_path.$file_name;

               } catch (Exception $e) {
                   $data['image'] = $_FILES['image']['name'];
               }
           }
           else{
                 if(isset($data['image']['value']) && $data['image']['value'] != '')
                 {
                     $data['image'] = $data['image']['value'];
                 }
                 else{
                     $data['image'] = '';
                 }

           }

            $id = $this->getRequest()->getParam('post_id');
            if ($id) {
                $model->load($id);
            }
           // $path = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('News and Events/');

            $model->setData($data);

            $this->_eventManager->dispatch(
                'blog_post_prepare_save',
                ['post' => $model, 'request' => $this->getRequest()]
            );
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this Post.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');

            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the post.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $this->getRequest()->getParam('post_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }


}

