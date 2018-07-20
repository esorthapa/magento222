<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 1/4/18
 * Time: 11:33 AM
 */

namespace Javra\Javraevents\Model\ResourceModel\Post\Relation\Store;

use Javra\Javraevents\Model\ResourceModel\Post;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

class ReadHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var Post
     */
    protected $resourcePost;

    /**
     * ReadHandler constructor.
     * @param MetadataPool $metadataPool
     * @param POst $resourcePost
     */
    public function __construct(
        MetadataPool $metadataPool,
        Post $resourcePost
    )
    {
        $this->metadataPool = $metadataPool;
        $this->resourcePost = $resourcePost;
    }

    /**
     * Perform action on relation/extension attribute
     *
     * @param object $entity
     * @param array $arguments
     * @return object|bool
     */
    public function execute($entity, $arguments = [])
    {
        if ($entity->getId()) {
            $stores = $this->resourcePost->lookupStoreIds((int) $entity->getId());
            $entity->setData('store_id', $stores);
            $entity->setData('store', $stores);
        }
        return $entity;
    }
}