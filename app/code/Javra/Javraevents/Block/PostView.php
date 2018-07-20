<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 11/29/17
 * Time: 1:29 PM
 */

namespace Javra\Javraevents\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template\Context;
use Javra\Javraevents\Model\Post;
use Javra\Javraevents\Model\PostFactory;
use Javra\Javraevents\Model\PostRepository;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Request\Http;


class PostView extends Template implements IdentityInterface
{
    protected $_post;
    protected $_postFactory;
    public $store;
    protected $postRepository;
    protected $storeManager;
    protected $request;

    public function __construct(
        Context $context,
        Post $post,
        PostFactory $postFactory,
        \Magento\Framework\View\Element\Template\Context $templateContext,
        PostRepository $postRepository,
        StoreManagerInterface $storeManager,
        Http $request,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_post = $post;
        $this->_postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->storeManager = $storeManager;
        $this->store = $templateContext->getStoreManager();
        $this->request = $request;

    }

    public function getPost()
    {
        // Check if posts has already been defined
        // makes our block nice and re-usable! We could
        // pass the 'posts' data to this block, with a collection
        // that has been filtered differently!
        if (!$this->hasData('post')) {

            if ($this->getPostId()) {
                /** @var \Javra\Javraevents\Model\Post $page */
                $post = $this->_postFactory->create();
            } else {
                $post = $this->_post;
            }
            $this->setData('post', $post);
        }
        return $this->getData('post');
    }

    public function getIdentities()
    {
        return [Post::CACHE_TAG . '_' . $this->getPost()->getId()];
    }

    /**
     * get media url
     * @return mixed
     */
    public function getBaseMediaUrl()
    {
        return $this->store->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    protected function _prepareLayout()
    {
       if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) { 
                $breadcrumbs->addCrumb('home', array('label'=>__('Home'), 'title'=>__('Go to Home Page'), 'link'=>$this->getBaseUrl()));
                $breadcrumbs->addCrumb('discover', array('label'=>__('Discover'), 'title'=>__('Discover'), 'link'=>$this->getBaseUrl().'discover.html'));
                $breadcrumbs->addCrumb('news-events', array('label'=>__('News & Events'), 'title'=>__('News & Events'), 'link'=>$this->getBaseUrl().'discover/news-events.html'));
                $breadcrumbs->addCrumb($this->getPost()->getTitle(), array('label'=>$this->getPost()->getTitle(), 'title'=>$this->getPost()->getTitle()));

    
            }
    }

    /**
     * Returns all the stores which specified post is associated with
     * @return bool|int[]
     */
    public function getStores()
    {
        $id =  $this->request->getParam('post_id');
        if ($id) {
            return $this->postRepository->getById($id)->getStores();
        }
        return [];
    }

    /**
     * Get Current Store
     * @return int
     */
    public function getCurrentStore()
    {
        return $this->storeManager->getStore()->getId();
    }

}