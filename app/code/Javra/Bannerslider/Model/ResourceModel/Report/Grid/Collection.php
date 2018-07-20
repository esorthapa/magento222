<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/5/18
 * Time: 12:51 PM
 */

namespace Javra\Bannerslider\Model\ResourceModel\Report\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;
use Javra\Bannerslider\Model\ResourceModel\Report\Collection as ReportCollection;
class Collection extends ReportCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface
     */
    protected $aggregations;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_requestInterface;

    /**
     * Collection constructor.
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Stdlib\DateTime\Timezone $stdTimezone
     * @param \Magento\Framework\App\RequestInterface $requestInterface
     * @param $mainTable
     * @param $eventPrefix
     * @param $eventObject
     * @param $resourceModel
     * @param string $model
     * @param null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\Timezone $stdTimezone,
        \Magento\Framework\App\RequestInterface $requestInterface,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $storeManager,
            $stdTimezone,
            $connection,
            $resource
        );
        $this->_requestInterface = $requestInterface;
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    protected function _beforeLoad()
    {
        parent::_beforeLoad();
        $actionName = $this->_requestInterface->getActionName();
        if($actionName == 'index'){
            $this->reportClickAndImpress(ReportCollection::REPORT_TYPE_PER_SLIDER);
        }else{
            $this->reportClickAndImpress(ReportCollection::REPORT_TYPE_ALL_SLIDER);
        }
        return $this;
    }
    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @param AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }


    /**
     * Retrieve all ids for collection
     * Backward compatibility with EAV collection
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
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

}