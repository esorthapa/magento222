<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/5/18
 * Time: 11:34 AM
 */

namespace Javra\Bannerslider\Model\ResourceModel\Slider\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;
use Javra\Bannerslider\Model\ResourceModel\Slider\Collection as SliderCollection;

class Collection extends SliderCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface
     */
    protected $aggregations;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\Timezone $stdTimezone,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
//        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $storeManager,
            $stdTimezone,
//            $connection,
            $resource
        );
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }


    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }


    public function setAggregations($aggregation)
    {
        $this->aggregations = $aggregation;
    }

    /**
     * @return \Magento\Framework\Api\Search\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;

    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return $this|SearchResultInterface
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;

    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();

    }

    /**
     * @param int $totalCount
     * @return $this|SearchResultInterface
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * @param array|null $items
     * @return $this|SearchResultInterface
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);

    }

}