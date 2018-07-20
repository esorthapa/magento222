<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/5/18
 * Time: 1:09 PM
 */

namespace Javra\Bannerslider\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

Class Slider implements ArrayInterface
{
    /**
     * @var sliderFactory
     */
    protected $sliderFactory;

    /**
     * Slider constructor.
     * @param \Javra\Bannerslider\Model\SliderFactory $sliderFactory
     */
    public function __construct(
        \Javra\Bannerslider\Model\SliderFactory $sliderFactory
    )
    {
        $this->sliderFactory = $sliderFactory;

    }

    /**
     * @return mixed
     * create slider with collection get data
     */
    public function getSliders()
    {
        $sliderModel = $this->sliderFactory->create();
        return $sliderModel->getColletion()->getData();
    }

    /**
     * @return array slider with id and title
     */
    public function toOptionArray()
    {
        // TODO: Implement toOptionArray() method.
        $sliders = [];
        foreach ($this->getSliders() as $slider) {
            array_push($sliders, [
                'value' => $sliders['slider_id'],
                'label' => $sliders['title']
            ]);
        }

        return $sliders;
    }

}