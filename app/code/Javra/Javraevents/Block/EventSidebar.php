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
use Magento\Store\Model\StoreManagerInterface;

class EventSidebar extends Template
{

    protected $_postCollectionFactory;
    protected $_postFactory;
    protected $storeManager;
    protected $countryFactory;
    


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CollectionFactory $postCollectionFactory,
        PostFactory $postFactory,
        StoreManagerInterface $storeManager,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_postCollectionFactory = $postCollectionFactory;
        $this->_postFactory = $postFactory;
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
        $posts->addFieldToFilter('main_table.type', 0);
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


    public function getPosts()
    {
        // Check if posts has already been defined
        // makes our block nice and re-usable! We could
        // pass the 'posts' data to this block, with a collection
        // that has been filtered differently!
        if (!$this->hasData('posts')) {
            $posts = $this->createInnerJoinedAndFilteredPostCollectionFactory()
//                ->create()
                ->addFilter('is_active', 1)
                ->addOrder(
                    PostInterface::CREATION_TIME,
                    PostCollection::SORT_ORDER_DESC
                );
            $this->setData('posts', $posts);
            $posts->setPageSize(4);
        }

        return $this->getData('posts');
    }

    /**
     * Get Current Store
     * @return mixed
     */
    public function getCurrentStore()
    {
        return $this->storeManager->getStore()->getId();
    }

    public function getCountryname($countryCode){
        $country = $this->countryFactory->create()->loadByCode($countryCode);
        return $country->getName();
    }
}
