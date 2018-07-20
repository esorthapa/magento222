<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/19/18
 * Time: 4:22 PM
 */

namespace Javra\Bannerslider\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
abstract class  BannerstatusActions extends \Javra\Bannerslider\Ui\Component\Listing\Column\AbstractColumn
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor.
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * prepare item.
     *
     * @param array $item
     *
     * @return $this
     */
    protected function _prepareItem(array & $item) {
        $itemsAction = $this->getData('itemsAction');
        $indexField = $this->getData('config/indexField');

        if (isset($item[$indexField])) {
            foreach ($itemsAction as $key => $itemAction) {
                $path = isset($itemAction['path']) ? $itemAction['path'] : null;
                $itemAction['href'] = $this->urlBuilder->getUrl(
                    $path,
                    [$indexField => $item[$indexField]]
                );
                $item[$this->getData('name')][$key] = $itemAction;
            }
        }

        return $item;
    }
}