<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 11/23/17
 * Time: 3:16 PM
 */

namespace Javra\Javraevents\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\MetadataPool;
use Javra\Javraevents\Api\Data\PostInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DB\Select;

class Post extends AbstractDb
{
    /**
     * @var DateTime
     */
    protected $_date;
    /**
     * @var setting store as null
     */
    protected $_store=null;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var DateTime
     */
    protected $dateTime;
    /**
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    public function __construct(
        Context $context,
        DateTime $date,
        StoreManagerInterface $storeManager,
        DateTime $dateTime,
        EntityManager $entityManager,
        MetadataPool $metadataPool,
        $connectionName = null,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $connectionName);
        $this->_date = $date;
        $this->storeManager = $storeManager;
        $this->dateTime = $dateTime;
        $this->entityManager = $entityManager;
        $this->metadataPool = $metadataPool;
    }

    protected function _construct()
    {
        $this->_init('javra_events', 'post_id');
    }

    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {

        if (!$this->isValidPostUrlKey($object)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The post URL key contains capital letters or disallowed symbols.')
            );
        }

        if ($this->isNumericPostUrlKey($object)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The post URL key cannot be made of only numbers.')
            );
        }

        if ($object->isObjectNew() && !$object->hasCreationTime()) {
            $object->setCreationTime($this->_date->gmtDate());
        }

        $object->setUpdateTime($this->_date->gmtDate());

        return parent::_beforeSave($object);
    }


    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        //post id for store view

//        if (!is_numeric($value) && is_null($field)) {
//            $field = 'url_key';
//        }
//
//        return parent::load($object, $value, $field);
        $postId = $this->getId($object, $value, $field);
        if ($postId) {
            $this->entityManager->load($object, $postId);
        }
        return $this;
    }


    protected function _getLoadSelect($field, $value, $object)
    {

        $entityMetadata = $this->metadataPool->getMetadata(\Javra\Javraevents\Api\Data\PostInterface::class);
        $linkField = $entityMetadata->getLinkField();
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = [
                Store::DEFAULT_STORE_ID,
                (int)$object->getStoreId(),
            ];
            $select->join(
                ['javra_events_store' => $this->getTable('javra_events_store')],
                $this->getMainTable() . '.' . $linkField . ' = javra_events_store.' . $linkField,
                []
            )
                ->where('is_active = ?', 1)
                ->where('javra_events_store.store_id IN (?)', $storeIds)
                ->order('javra_events_store.store_id DESC')
                ->limit(1);
//            $select->where(
//                'is_active = ?',
//                1
//            )->limit(
//                1
//            );
        }

        return $select;
    }


    protected function _getLoadByUrlKeySelect($url_key, $isActive = null)
    {
        $select = $this->getConnection()->select()->from(
            ['bp' => $this->getMainTable()]
        )->where(
            'bp.url_key = ?',
            $url_key
        );

        if (!is_null($isActive)) {
            $select->where('bp.is_active = ?', $isActive);
        }
        return $select;
    }


    protected function isNumericPostUrlKey(\Magento\Framework\Model\AbstractModel $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('url_key'));
    }


    protected function isValidPostUrlKey(\Magento\Framework\Model\AbstractModel $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('url_key'));
    }

    public function checkUrlKey($url_key)
    {
        $select = $this->_getLoadByUrlKeySelect($url_key, 1);
        $select->reset(\Zend_Db_Select::COLUMNS)->columns('bp.post_id')->limit(1);

        return $this->getConnection()->fetchOne($select);
    }

    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection()
    {
        $connection=$this->metadataPool->getMetadata(PostInterface::class)->getEntityConnection();

        return $connection;
    }

    /**
     * @param AbstractModel $object
     * @param $value
     * @param null $field
     * @return bool|int|string
     */
    private function getId(AbstractModel $object, $value, $field = null)
    {

        $entityMetadata = $this->metadataPool->getMetadata(PostInterface::class);

        if (!is_numeric($value) && $field === null) {
            $field = 'post_id';
        } elseif (!$field) {
            $field = $entityMetadata->getIdentifierField();
        }

        $postId = $value;
        if ($field != $entityMetadata->getIdentifierField() || $object->getStoreId()) {
            $select = $this->_getLoadSelect($field, $value, $object);
            $select->reset(Select::COLUMNS)
                ->columns($this->getMainTable() . '.' . $entityMetadata->getIdentifierField())
                ->limit(1);
            $result = $this->getConnection()->fetchCol($select);
            $postId = count($result) ? $result[0] : false;
        }
        return $postId;
    }

    public function lookupStoreIds($id)
    {
        $connection = $this->getConnection();

        $entityMetadata = $this->metadataPool->getMetadata(PostInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select = $connection->select()
            ->from(['javra_events_store' => $this->getTable('javra_events_store')], 'store_id')
            ->join(
                ['javra_events' => $this->getMainTable()],
                'javra_events_store.' . $linkField . ' = javra_events.' . $linkField,
                []
            )
            ->where('javra_events.' . $entityMetadata->getIdentifierField() . ' = :post_id');

        return $connection->fetchCol($select, ['post_id' => (int)$id]);
    }

    public function setStore($store)
    {
        $this->_store = $store;
        return $this;
    }

    public function getStore()
    {
        return $this->_storeManager->getStore($this->_store);
    }

    public function save(AbstractModel $object)
    {
        $this->entityManager->save($object);
        return $this;
    }

    public function delete(AbstractModel $object)
    {
        $this->entityManager->delete($object);
        return $this;
    }

}
