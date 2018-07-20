<?php

namespace Javra\Javraevents\Block;

use Javra\Javraevents\Api\Data\PostInterface;
use Javra\Javraevents\Model\ResourceModel\Post\Collection as PostCollection;
use Javra\Javraevents\Model\NewsFactory;
use Magento\Framework\View\Element\Template;
use Javra\Javraevents\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Javra\Javraevents\Model\Post;
use Javra\Javraevents\Model\PostFactory;
use \Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

class PostList extends Template implements IdentityInterface
{

    protected $_postCollectionFactory;
    protected $_postFactory;
    public $store;
    protected $pageSize;
    protected $pageNumber;
    protected $_newsFactory;
    protected $pageType;
    const news = 1;
    const events = 0;
    protected $storeManager;
    protected $countryFactory;

    public function __construct(
        Context $context,
        CollectionFactory $postCollectionFactory,
        PostFactory $postFactory,
        StoreManagerInterface $storeManager,
        \Magento\Framework\View\Element\Template\Context $templateContext,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_postCollectionFactory = $postCollectionFactory;
        $this->_postFactory = $postFactory;
        $this->store = $templateContext->getStoreManager();
        $this->storeManager = $storeManager;
        $this->countryFactory = $countryFactory;
    }

    /**
     * Returns Post Collection Factory
     * InnerJoin with Store
     * @return \Javra\Javraevents\Model\ResourceModel\Post\Collection
     */
    private function createInnerJoinedAndFilteredPostCollectionFactory()
    {
        $posts = $this->_postCollectionFactory->create();
        $posts->join(
            ['javra_events_store' => $posts->getTable('javra_events_store')],
            'main_table.post_id = javra_events_store.post_id',
            '*'
        )
            ->addFieldToFilter(
                'store_id',
                [$this->getCurrentStore(), 0]
            );

        return $posts;
    }

    /**
     * Get Current Store
     * @return mixed
     */
    public function getCurrentStore()
    {
        return $this->storeManager->getStore()->getId();
    }

    public function getPosts()
    {
        // Check if posts has already been defined
        // makes our block nice and re-usable! We could
        // pass the 'posts' data to this block, with a collection
        // that has been filtered differently!
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $this->pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 4;
        $type = $this->getRequest()->getParam('type');
        $today = date("Y-m-d H:i:s");

        if (!$this->hasData('posts')) {
            if (isset($type) && $type !== 'ALL' && $type !== 'NaN') {
                $posts = $this->createInnerJoinedAndFilteredPostCollectionFactory()
                    //->create()
                    ->addFilter('is_active', 1)
                    ->addFilter('type', $type)
                    ->distinct(true)
                    ->addOrder(
                        PostInterface::START_DATE,
                        PostCollection::SORT_ORDER_DESC
                    );

            } else {
                $posts = $this->createInnerJoinedAndFilteredPostCollectionFactory()
                    //->create()
                    ->addFilter('is_active', 1)
                    ->distinct(true)
                    ->addOrder(
                        PostInterface::START_DATE,
                        PostCollection::SORT_ORDER_DESC
                    );
            }

//            $posts->addFieldToFilter('end_date', array('gt' => $today));
            $this->setData('posts', $posts);
            $posts->setPageSize($this->pageSize);
            $posts->setCurPage($page);

        }
        return $this->getData('posts');
    }

    public function getIdentities()
    {
        return [Post::CACHE_TAG . '_' . 'list'];
    }

    /*
    *To limit the latestNews and events order by date and limit 2
    */
    public function getLatestNews()
    {
        $collection = $this->createInnerJoinedAndFilteredPostCollectionFactory()
                    ->addFilter('is_active', 1)
                    ->addFilter('type', 0)
                    ->distinct(true)
                    ->addOrder(
                        PostInterface::START_DATE,
                        PostCollection::SORT_ORDER_DESC
                    );
                    $collection->getSelect()
                    ->limit(2);
        
        return $collection;
    }

    /*
   *To limit the number of page in event list to load more
   */
    public function getTotalPagesAll()
    {
        $this->pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 4;
        return ceil($this->createInnerJoinedAndFilteredPostCollectionFactory()->count() / $this->pageSize);

    }

    /*
      *To limit the number of News Page with type in event list to load more
      */

    public function getTotalPagesNews()
    {
        $this->pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 4;
        return ceil($this->createInnerJoinedAndFilteredPostCollectionFactory()->addFilter('type', self::news)->addFilter('is_active', 1)->count() / $this->pageSize);

    }

    /*
      *To limit the number of Events Page with type in event list to load more
      */
    public function getTotalPagesEvents()
    {
        $this->pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 4;
//
        return ceil($this->createInnerJoinedAndFilteredPostCollectionFactory()->addFilter('type', self::events)->addFilter('is_active', 1)->count() / $this->pageSize);
    }

    /*
     *To provide type of request provided
     */

    public function getType()
    {
        $this->pageType = $this->getRequest()->getParam('type');
        return $this->pageType;
    }

    /*
     *To Provide number of page of the load more
     */
    public function getPagesNumber()
    {
        $this->pageNumber = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        return $this->pageNumber;
    }

    /**
     * get media url
     * @return mixed
     */
    public function getBaseMediaUrl()
    {
        return $this->store->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /*
     * Apply the code for country name in list.phtml if needed
     */

    public function getCountryname($countryCode){
        $country = $this->countryFactory->create()->loadByCode($countryCode);
        return $country->getName();
    }

}
