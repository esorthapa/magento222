<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 11/29/17
 * Time: 4:43 PM
 */

namespace Javra\Javraevents\Helper;

use Magento\Framework\App\Action\Action;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;



class Post extends AbstractHelper
{
    protected $_post;

    protected $resultPageFactory;

    protected $_scopeConfig;


    public function __construct(
        Context $context,
        \Javra\Javraevents\Model\Post $post,
        PageFactory $resultPageFactory,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_post = $post;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }


    public function prepareResultPost(Action $action, $postId = null)
    {
        if ($postId !== null && $postId !== $this->_post->getId()) {
            $delimiterPosition = strrpos($postId, '|');
            if ($delimiterPosition) {
                $postId = substr($postId, 0, $delimiterPosition);
            }

            if (!$this->_post->load($postId)) {
                return false;
            }
        }

        if (!$this->_post->getId()) {
            return false;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        // We can add our own custom page handles for layout easily.
        $resultPage->addHandle('blog_post_view');

        // This will generate a layout handle like: blog_post_view_id_1
        // giving us a unique handle to target specific blog posts if we wish to.
        $resultPage->addPageLayoutHandles(['id' => $this->_post->getId()]);

        // Magento is event driven after all, lets remember to dispatch our own, to help people
        // who might want to add additional functionality, or filter the posts somehow!
        $this->_eventManager->dispatch(
            'ashsmith_blog_post_render',
            ['post' => $this->_post, 'controller_action' => $action]
        );

        return $resultPage;
    }

    public function getLastestNewsBlockPosition()
    {
        return $this->_scopeConfig->getValue(
            ScopeInterface::SCOPE_STORE
        );
    }
}
