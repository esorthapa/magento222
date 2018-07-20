<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 11/29/17
 * Time: 4:38 PM
 */

namespace Javra\Javraevents\Controller;

use \Magento\Framework\App\RouterInterface;
use \Magento\Framework\App\ActionFactory;
use \Javra\Javraevents\Model\PostFactory;
use \Magento\Framework\App\RequestInterface;
use \Magento\Framework\Url;
use \Magento\Framework\App\ResponseInterface;
use \Magento\Framework\Event\ManagerInterface;
use   \Magento\Framework\UrlInterface;

class Router implements RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;


    protected $_postFactory;

    protected $_eventManager;

    protected $_appState;
    protected $_url;

    protected $_response;


    public function __construct(
        ActionFactory $actionFactory,
        PostFactory $postFactory,
       ManagerInterface $eventManager,
        UrlInterface $url,
       ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->_eventManager = $eventManager;
        $this->_url = $url;
        $this->_pageFactory = $postFactory;
        $this->_response = $response;
    }

    public function match(RequestInterface $request)
    {
        
        
        $url = trim($request->getPathInfo());

        $url_key = explode('/', $url);
        $url_key = end($url_key);


        
        /** @var \Javra\Javraevents\Model\Post $post */
        $post = $this->_pageFactory->create();
        $post_id = $post->checkUrlKey($url_key);
        
        if (!$post_id) {
            return null;
        }

        $request->setModuleName('discover')
            ->setControllerName('view')
            ->setActionName('index')
            ->setParam('post_id', $post_id);
        $request->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $url_key);

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}
