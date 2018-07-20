<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 1/4/18
 * Time: 11:36 AM
 */

namespace Javra\Javraevents\Model\ResourceModel\Post\Relation\Store;

use Javra\Javraevents\Model\ResourceModel\Post;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Javra\Javraevents\Api\Data\PostInterface;
use Magento\Framework\EntityManager\MetadataPool;


class SaveHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;
    /**
     * @var Post
     */
    protected $resourcePost;

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
        $entityMetadata = $this->metadataPool->getMetadata(PostInterface::class);

        $linkField = $entityMetadata->getLinkField();

        $connection = $entityMetadata->getEntityConnection();

        $oldStores = $this->resourcePost->lookupStoreIds((int) $entity->getId());
        $newStores = (array) $entity->getStores();

        if (empty($newStores)) {
            $newStores = (array) $entity->getStoreId();
        }

        $table = $this->resourcePost->getTable('javra_events_store');

        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = [
                $linkField . ' = ?' => (int) $entity->getData($linkField),
                'store_id IN (?)' => $delete,
            ];

            $connection->delete($table, $where);
        }

        $insert = array_diff($newStores, $oldStores);

        if ($insert) {
            $data = [];

            foreach ($insert as $storeId) {
                $data[] = [
                    $linkField => (int) $entity->getData($linkField),
                    'store_id' => (int) $storeId
                ];
            }

            $connection->insertMultiple($table, $data);
        }
        return $entity;
    }
}