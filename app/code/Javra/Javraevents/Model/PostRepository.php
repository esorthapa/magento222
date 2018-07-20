<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 1/4/18
 * Time: 12:20 PM
 */

namespace Javra\Javraevents\Model;

use Javra\Javraevents\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Javra\Javraevents\Model\ResourceModel\Post as ResourcePost;
use Javra\Javraevents\Model\PostFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\SortOrder;
use Javra\Javraevents\Api\PostRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Javra\Javraevents\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Javra\Javraevents\Api\Data\PostInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

class PostRepository implements postRepositoryInterface
{
    /**
     * @var ResourcePost
     */
    protected $resource;
    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var PostCollectionFactory
     */
    protected $postCollectionFactory;
    /**
     * @var PostInterfaceFactory
     */
    protected $dataPostFactory;
//    /**
//     * @var JobSearchResultsInterfaceFactory
//     */
//    protected $searchResultsFactory;
    /**
     * @var PostFactory
     */
    protected $postFactory;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @param ResourcePost $resource
     * @param PostFactory $postFactory
     * @param PostInterfaceFactory $dataPostFactory
     * @param PostCollectionFactory $postCollectionFactory

     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourcePost $resource,
        PostFactory $postFactory,
        PostInterfaceFactory $dataPostFactory,
        PostCollectionFactory $postCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataPostFactory = $dataPostFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * Save Post Data
     *
     * @param PostInterface $post
     * @return PostInterface
     * @throws CouldNotSaveException
     */
    public function save(
        PostInterface $post
    ) {

        if (empty($post->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $post->setStoreId($storeId);
        }

        try {
            $post->getResource()->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the post: %1',
                $exception->getMessage()
            ));
        }
        return $post;
    }

    /**
     * Load Post data by given post Identity
     *
     * @param string $postId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($postId)
    {
        $post = $this->postFactory->create();
        $post->getResource()->load($post, $postId);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $postId));
        }
        return $post;
    }

    /**
     * Load Post data collection by given search criteria
     * @param SearchCriteriaInterface $criteria
     * @return mixed
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ) {
        $collection = $this->postCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
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
     * Delete Post
     * @param PostInterface $post
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(
        PostInterface $post
    ) {
        try {
            $post->getResource()->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Post: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete Post by given Post Identity
     * @param string $postId
     * @return bool
     */
    public function deleteById($postId)
    {
        return $this->delete($this->getById($postId));
    }
}