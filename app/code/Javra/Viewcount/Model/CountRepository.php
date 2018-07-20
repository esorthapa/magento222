<?php
/**
 * This Module is generate number of count which like by user.
 * Copyright (C) 2017 www.javra.com 
 * 
 * This file is part of Javra/Viewcount.
 * 
 * Javra/Viewcount is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Javra\Viewcount\Model;

use Javra\Viewcount\Api\CountRepositoryInterface;
use Javra\Viewcount\Api\Data\CountSearchResultsInterfaceFactory;
use Javra\Viewcount\Api\Data\CountInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Javra\Viewcount\Model\ResourceModel\Count as ResourceCount;
use Javra\Viewcount\Model\ResourceModel\Count\CollectionFactory as CountCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class CountRepository implements CountRepositoryInterface
{

    protected $resource;

    protected $countFactory;

    protected $countCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataCountFactory;

    private $storeManager;


    /**
     * @param ResourceCount $resource
     * @param CountFactory $countFactory
     * @param CountInterfaceFactory $dataCountFactory
     * @param CountCollectionFactory $countCollectionFactory
     * @param CountSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceCount $resource,
        CountFactory $countFactory,
        CountInterfaceFactory $dataCountFactory,
        CountCollectionFactory $countCollectionFactory,
        CountSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->countFactory = $countFactory;
        $this->countCollectionFactory = $countCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataCountFactory = $dataCountFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Javra\Viewcount\Api\Data\CountInterface $count
    ) {
        /* if (empty($count->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $count->setStoreId($storeId);
        } */
        try {
            $this->resource->save($count);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the count: %1',
                $exception->getMessage()
            ));
        }
        return $count;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($countId)
    {
        $count = $this->countFactory->create();
        $this->resource->load($count, $countId);
        if (!$count->getId()) {
            throw new NoSuchEntityException(__('Count with id "%1" does not exist.', $countId));
        }
        return $count;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->countCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $fields[] = $filter->getField();
                $condition = $filter->getConditionType() ?: 'eq';
                $conditions[] = [$condition => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Javra\Viewcount\Api\Data\CountInterface $count
    ) {
        try {
            $this->resource->delete($count);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Count: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($countId)
    {
        return $this->delete($this->getById($countId));
    }
}
