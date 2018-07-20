<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/4/18
 * Time: 1:00 PM
 */

namespace Javra\Bannerslider\Model;

use Magento\Framework\Model\AbstractModel;

class Banner extends AbstractModel
{
    const BASE_MEDIA_PATH = 'javra/bannerslider/images';

    const BANNER_TARGET_SELF = 0;
    const BANNER_TARGET_PARENT = 1;
    const BANNER_TARGET_BLANK = 2;

    /**
     * slider colleciton factory.
     *
     * @var \Javra\Bannerslider\Model\ResourceModel\Slider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * store view id.
     *
     * @var int
     */
    protected $_storeViewId = null;

    /**
     * banner factory.
     *
     * @var \Javra\Bannerslider\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * value factory.
     *
     * @var \Javra\Bannerslider\Model\ValueFactory
     */
    protected $_valueFactory;

    /**
     * value collecion factory.
     *
     * @var \Javra\Bannerslider\Model\ResourceModel\Value\CollectionFactory
     */
    protected $_valueCollectionFactory;

    /**
     * [$_formFieldHtmlIdPrefix description].
     *
     * @var string
     */
    protected $_formFieldHtmlIdPrefix = 'page_';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * logger.
     *
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $_monolog;

    /**
     * [__construct description].
     *
     * @param \Magento\Framework\Model\Context                                $context
     * @param \Magento\Framework\Registry                                     $registry
     * @param \Javra\Bannerslider\Model\ResourceModel\Banner                   $resource
     * @param \Javra\Bannerslider\Model\ResourceModel\Banner\Collection        $resourceCollection
     * @param \Javra\Bannerslider\Model\BannerFactory                     $bannerFactory
     * @param \Javra\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Javra\Bannerslider\Model\ResourceModel\Value\CollectionFactory  $valueCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface                      $storeManager
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Javra\Bannerslider\Model\ResourceModel\Banner $resource,
        \Javra\Bannerslider\Model\ResourceModel\Banner\Collection $resourceCollection,
        \Javra\Bannerslider\Model\BannerFactory $bannerFactory,
        \Javra\Bannerslider\Model\ValueFactory $valueFactory,
        \Javra\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Javra\Bannerslider\Model\ResourceModel\Value\CollectionFactory $valueCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Logger\Monolog $monolog
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_bannerFactory = $bannerFactory;
        $this->_valueFactory = $valueFactory;
        $this->_valueCollectionFactory = $valueCollectionFactory;
        $this->_storeManager = $storeManager;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;

        $this->_monolog = $monolog;

        if ($storeViewId = $this->_storeManager->getStore()->getId()) {
            $this->_storeViewId = $storeViewId;
        }
    }

    /**
     * get form field html id prefix.
     *
     * @return string
     */
    public function getFormFieldHtmlIdPrefix()
    {
        return $this->_formFieldHtmlIdPrefix;
    }

    /**
     * get availabe slide.
     *
     * @return []
     */
    public function getAvailableSlides()
    {
        $option[] = [
            'value' => '',
            'label' => __('-------- Please select a slider --------'),
        ];

        $sliderCollection = $this->_sliderCollectionFactory->create();
        foreach ($sliderCollection as $slider) {
            $option[] = [
                'value' => $slider->getId(),
                'label' => $slider->getTitle(),
            ];
        }

        return $option;
    }

    /**
     * get store attributes.
     *
     * @return array
     */
    public function getStoreAttributes()
    {
        return array(
            'name',
            'status',
            'click_url',
            'target',
            'image_alt',
            'image',
            'caption'
        );
    }

    /**
     * get store view id.
     *
     * @return int
     */
    public function getStoreViewId()
    {
        return $this->_storeViewId;
    }

    /**
     * set store view id.
     *
     * @param int $storeViewId
     */
    public function setStoreViewId($storeViewId)
    {
        $this->_storeViewId = $storeViewId;

        return $this;
    }

    /**
     * before save.
     */
    public function beforeSave()
    {
        if ($this->getStoreViewId()) {
            $defaultStore = $this->_bannerFactory->create()->setStoreViewId(null)->load($this->getId());
            $storeAttributes = $this->getStoreAttributes();
            $data = $this->getData();
            foreach ($storeAttributes as $attribute) {
                if (isset($data['use_default']) && isset($data['use_default'][$attribute])) {
                    $this->setData($attribute.'_in_store', false);
                } else {
                    $this->setData($attribute.'_in_store', true);
                    $this->setData($attribute.'_value', $this->getData($attribute));
                }
                $this->setData($attribute, $defaultStore->getData($attribute));
            }
        }

        return parent::beforeSave();
    }


    public function afterSave()
    {
        if ($storeViewId = $this->getStoreViewId()) {
            $storeAttributes = $this->getStoreAttributes();
            $collectionBanner = $this->_valueCollectionFactory->create();
            $attributeValue = $this->_valueFactory->create()
                ->loadAttributeValue($this->getId(), $storeViewId, $storeAttributes, $collectionBanner);
            foreach ($attributeValue as $model) {
                if ($this->getData($model->getData('attribute_code') . '_in_store')) {
                    try {
                        if ($model->getData('attribute_code') == 'image' && $this->getData('delete_image')) {
                            $model->delete();
                        } else {
                            $model->setValue($this->getData($model->getData('attribute_code') . '_value'))->save();
                        }
                    } catch (\Exception $e) {
                        $this->_monolog->addError($e->getMessage());
                    }
                } elseif ($model && $model->getId()) {
                    try {
                        $model->delete();
                    } catch (\Exception $e) {
                        $this->_monolog->addError($e->getMessage());
                    }
                }
            }

        }
        return parent::afterSave();
    }
    /**
     * load info multistore.
     *
     * @param mixed  $id
     * @param string $field
     *
     * @return $this
     */
    public function load($id, $field = null)
    {
        parent::load($id, $field);
        if ($this->getStoreViewId()) {
            $this->getStoreViewValue();
        }

        return $this;
    }

    /**
     * get store view value.
     *
     * @param string|null $storeViewId
     *
     * @return $this
     */
    public function getStoreViewValue($storeViewId = null)
    {
        if (!$storeViewId) {
            $storeViewId = $this->getStoreViewId();
        }
        if (!$storeViewId) {
            return $this;
        }
        $storeValues = $this->_valueCollectionFactory->create()
            ->addFieldToFilter('banner_id', $this->getId())
            ->addFieldToFilter('store_id', $storeViewId);
        foreach ($storeValues as $value) {
            $this->setData($value->getAttributeCode().'_in_store', true);
            $this->setData($value->getAttributeCode(), $value->getValue());
        }

        return $this;
    }

    /**
     * get target value.
     *
     * @return string
     */
    public function getTargetValue()
    {
        switch ($this->getTarget()) {
            case self::BANNER_TARGET_SELF:
                return '_self';
            case self::BANNER_TARGET_PARENT:
                return '_parent';

            default:
                return '_blank';
        }
    }

}