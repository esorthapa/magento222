<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/3/18
 * Time: 2:53 PM
 */

namespace Javra\Bannerslider\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class AbstractAction extends Action
{
    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $_jsHelper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */

    protected $_resultLayoutFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */

    protected $_fileFactory;

    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */

    protected $_massActionFilter;
    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */

    protected $_uploaderFactory;

    /**
     * @var \Magento\Framework\Image\AdapterFactory
     */

    protected $_adapterFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Javra\Bannerslider\Model\BannerFactory $bannerFactory,
        \Javra\Bannerslider\Model\SliderFactory $sliderFactory,
        \Javra\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Javra\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\Helper\Js $jsHelper,
        \Magento\Ui\Component\MassAction\Filter $massActionFilter,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Framework\Image\AdapterFactory $adapterFactory

    )
    {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_fileFactory = $fileFactory;
        $this->_storeManager = $storeManager;
        $this->_jsHelper = $jsHelper;
        $this->_massActionFilter = $massActionFilter;

        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultLayoutFactory = $resultLayoutFactory;
        $this->_resultForwardFactory = $resultForwardFactory;

        $this->_bannerFactory = $bannerFactory;
        $this->_sliderFactory = $sliderFactory;
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
        $this->_uploaderFactory = $uploaderFactory;
        $this->_adapterFactory = $adapterFactory;

    }

    public function _createMainCollection()
    {
        $collectin = $this->create('');
        return $collectin;
    }

    protected function _getBackResultRedirect(\Magento\Framework\Controller\Result\Redirect $resultRedirect, $paramCrudId = null)
    {
        switch ($this->getRequest()->getParam('back')) {
            case 'edit':
                $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        static::PARAM_CRUD_ID => $paramCrudId,
                        '_current' => true,
                    ]
                );
                break;
            case 'new':
                $resultRedirect->setPath('*/*/new', ['_current' => true]);
                break;
            default:
                $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }


}