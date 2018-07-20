<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 4:01 PM
 */

namespace Javra\Bannerslider\Controller\Index;


class Impress extends \Javra\Bannerslider\Controller\Index
{

    public function execute()
    {
        $resultRaw = $this->_resultRawFactory->create();
        $userCode = $this->getUserCode(null);
        $date = $this->_stdTimezone->date()->format('Y-m-d');
        $sliderId = $this->getRequest()->getParam('slider_id');
        $slider = $this->_sliderFactory->create()->load($sliderId);
        if ($slider->getId()) {
            $sliderOwnBannerCollection = $slider->getOwnBanerCollection();
            if ($slider->getStyleSlide() == \Javra\Bannerslider\Model\Slider::STYLESLIDE_POPUP) {
                $sliderOwnBannerCollection->setPageSize(1)->setCurPage(1);
            }
            $bannerIds = $sliderOwnBannerCollection->getColumnValues('banner_id');
            if ($this->getCookieManager()->getCookie('bannerslider_user_code_impress_slider'.$sliderId) === null) {
                $this->getCookieManager()->setPublicCookie('bannerslider_user_code_impress_slider'.$sliderId, $userCode);
                $reportCollection = $this->_reportCollectionFactory->create()
                    ->addFieldToFilter('date_click', $date)
                    ->addFieldToFilter('slider_id', $sliderId)
                    ->addFieldToFilter('banner_id', array('in' => $bannerIds));

                foreach ($reportCollection as $report) {
                    $report->setImpmode($report->getImpmode() + 1);
                    try {
                        $report->save();
                    } catch (\Exception $e) {
                        $this->_monolog->addError($e->getMessage());
                    }
                }

                //Banner Ids reported
                $bannerIdsReported = $reportCollection->getColumnValues('banner_id');

                //Banner Ids reported
                $bannerIdsNotReported = array_diff($bannerIds, $bannerIdsReported);
                foreach ($bannerIdsNotReported as $bannerId) {
                    $report = $this->_reportFactory->create()
                        ->setBannerId($bannerId)
                        ->setSliderId($slider->getId())
                        ->setImpmode(1)
                        ->setData('date_click', $date);
                    try {
                        $report->save();
                    } catch (\Exception $e) {
                        $this->_monolog->addError($e->getMessage());
                    }
                }
            }
        }

        return $resultRaw;
    }


}