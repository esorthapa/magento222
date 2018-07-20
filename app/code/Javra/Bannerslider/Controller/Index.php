<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 3:58 PM
 */

namespace Javra\Bannerslider\Controller;


abstract class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Slider factory.
     *
     * @var \Javra\Bannerslider\Model\SliderFactory
     */
    protected $_sliderFactory;

    /**
     * banner factory.
     *
     * @var \Javra\Bannerslider\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * Report factory.
     *
     * @var \Javra\Bannerslider\Model\ReportFactory
     */
    protected $_reportFactory;

    /**
     * Report collection factory.
     *
     * @var \Javra\Bannerslider\Model\ResourceModel\Report\CollectionFactory
     */
    protected $_reportCollectionFactory;

    /**
     * A result that contains raw response - may be good for passing through files
     * returning result of downloads or some other binary contents.
     *
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $_resultRawFactory;


    /**
     * logger.
     *
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $_monolog;

    /**
     * stdlib timezone.
     *
     * @var \Magento\Framework\Stdlib\DateTime\Timezone
     */
    protected $_stdTimezone;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context                                $context
     * @param \Javra\Bannerslider\Model\SliderFactory                          $sliderFactory
     * @param \Javra\Bannerslider\Model\BannerFactory                          $bannerFactory
     * @param \Javra\Bannerslider\Model\ReportFactory                          $reportFactory
     * @param \Javra\Bannerslider\Model\ResourceModel\Report\CollectionFactory $reportCollectionFactory
     * @param \Magento\Framework\Controller\Result\RawFactory                      $resultRawFactory
     * @param \Magento\Framework\Logger\Monolog                                    $monolog
     * @param \Magento\Framework\Stdlib\DateTime\Timezone                          $stdTimezone
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Javra\Bannerslider\Model\SliderFactory $sliderFactory,
        \Javra\Bannerslider\Model\BannerFactory $bannerFactory,
        \Javra\Bannerslider\Model\ReportFactory $reportFactory,
        \Javra\Bannerslider\Model\ResourceModel\Report\CollectionFactory $reportCollectionFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\Logger\Monolog $monolog,
        \Magento\Framework\Stdlib\DateTime\Timezone $stdTimezone
    ) {
        parent::__construct($context);
        $this->_sliderFactory = $sliderFactory;
        $this->_bannerFactory = $bannerFactory;
        $this->_reportFactory = $reportFactory;
        $this->_reportCollectionFactory = $reportCollectionFactory;

        $this->_resultRawFactory = $resultRawFactory;
        $this->_monolog = $monolog;
        $this->_stdTimezone = $stdTimezone;
    }


    public function getCookieManager(){
        return $this->_objectManager->create('Magento\Framework\Stdlib\CookieManagerInterface');
    }
    /**
     * get user code.
     *
     * @param mixed $id
     *
     * @return string
     */
    protected function getUserCode($id)
    {
        $ipAddress = $this->_objectManager->create('Magento\Framework\HTTP\PhpEnvironment\Request')->getClientIp(true);
//        var_dump($ipAddress);die('ssssssss');
        $cookiefrontend = $this->getCookieManager()->getCookie('frontend');
        $usercode = $ipAddress.$cookiefrontend.$id;

        return md5($usercode);
    }
}