<?php

namespace Javra\Javraevents\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class ImagePath extends AbstractHelper
{
    protected $directoryList;
    protected $storeManger;
    protected $baseMediaDirectory;


    public function __construct(Context $context, DirectoryList $directoryList, StoreManagerInterface $storeManager)
    {
        parent::__construct($context);
        $this->directoryList = $directoryList;
        $this->storeManger = $storeManager;
    }


    public function getBaseMediaDirectoryPath()
    {
        return $this->directoryList->getPath($this->baseMediaDirectory ?: 'media');
    }

    public function getBaseMediaUrl()
    {
        return $this->storeManger->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }

    public function getImageUrl($imagePath)
    {
        if ($imagePath != '' && file_exists($this->getBaseMediaDirectoryPath() . '/' . $imagePath))
        {
            return $this->getBaseMediaUrl() . $imagePath;
        } else {
            return $this->getBaseMediaUrl() . 'catalog/product/placeholder/default/placeholder.jpg';
        }
    }

    /**
     * @return mixed
     */
    public function getBaseMediaDirectory()
    {
        return $this->baseMediaDirectory;
    }

    /**
     * @param mixed $baseMediaDirectory
     */
    public function setBaseMediaDirectory($baseMediaDirectory)
    {
        $this->baseMediaDirectory = $baseMediaDirectory;
    }


}