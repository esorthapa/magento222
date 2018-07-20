<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 7/18/18
 * Time: 11:37 AM
 */

namespace Javra\Viewcount\Controller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;
use Javra\Viewcount\Model\CountFactory;


abstract class Count extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var \Javra\Viewcount\Model\CountFactory
     */
    protected $_countFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CountFactory $countFactory
    )
    {
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
        $this->_countFactory = $countFactory;
    }

    public function dispatch(RequestInterface $request)
    {
        // Check this module is enabled in frontend

            $result = parent::dispatch($request);
            return $result;
    }



}