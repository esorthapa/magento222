<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 12:47 PM
 */

namespace Javra\Bannerslider\Block;

use Javra\Bannerslider\Model\Slider as SliderModel;
use Javra\Bannerslider\Model\Status;
class Bannerslider extends \Magento\Framework\View\Element\Template
{
    /**
     * banner slider template
     * @var string
     */
    protected $_template = 'Javra_Bannerslider::bannerslider.phtml';

    /**
     * Registry object.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * slider collecion factory.
     *
     * @var \Javra\Bannerslider\Model\ResourceModel\Slider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * [__construct description].
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Javra\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Javra\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Javra\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Javra\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_coreRegistry = $coreRegistry;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
    }

    /**
     * @return
     */
    protected function _toHtml()
    {
        $store = $this->_storeManager->getStore()->getId();

        if ($this->_scopeConfig->getValue(
            SliderModel::XML_CONFIG_BANNERSLIDER, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store
        )
        ) {
            return parent::_toHtml();
        }

        return '';
    }

    /**
     * add child block slider.
     *
     * @param \Javra\Bannerslider\Model\ResourceModel\Slider\Collection $sliderCollection [description]
     *
     * @return \Javra\Bannerslider\Block\Bannerslider [description]
     */
    public function appendChildBlockSliders(
        \Javra\Bannerslider\Model\ResourceModel\Slider\Collection $sliderCollection
    )
    {
        foreach ($sliderCollection as $slider) {
            $this->append(
                $this->getLayout()->createBlock(
                    'Javra\Bannerslider\Block\SliderItem'
                )->setSliderId($slider->getId())
            );
        }

        return $this;
    }

    /**
     * set position for banner slider.
     *
     * @param mixed string|array $position
     */
    public function setPosition($position)
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }

    /**
     * set position for banner slider.
     *
     * @param mixed string|array $position
     */
    public function setCategoryPosition($position)
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $category = $this->_coreRegistry->registry('current_category');
        if (!is_null($category)) {
            $categoryPathIds = $category->getPathIds();

            foreach ($sliderCollection as $slider) {
                $sliderCategoryIds = explode(',', $slider->getCategoryIds());
                if (count(array_intersect($categoryPathIds, $sliderCategoryIds)) > 0) {
                    $this->append(
                        $this->getLayout()->createBlock(
                            'Javra\Bannerslider\Block\SliderItem'
                        )->setSliderId($slider->getId())
                    );
                }
            }
        }
        return $this;
    }

    /**
     * set position for note.
     */
    public function setPositionNote()
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('style_content', SliderModel::STYLE_CONTENT_YES)
            ->addFieldToFilter('style_slide', SliderModel::STYLESLIDE_SPECIAL_NOTE)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);

        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }

    /**
     * set popup on home page.
     */
    public function setPopupOnHomePage()
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('style_content', SliderModel::STYLE_CONTENT_YES)
            ->addFieldToFilter('style_slide', SliderModel::STYLESLIDE_POPUP)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }
}