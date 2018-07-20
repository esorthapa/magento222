<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 1/4/18
 * Time: 3:49 PM
 */

namespace Javra\Javraevents\Model;
use Javra\Javraevents\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var ResourceModel\Post\Collection
     */
    protected $collection;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var array
     */
    protected $loadedData;

    /**
    * DataProvider constructor.
    * @param string $name
    * @param string $primaryFieldName
    * @param string $requestFieldName
    * @param array $meta
    * @param array $data
    * @param CollectionFactory $pageCollectionFactory
    * @param DataPersistorInterface $dataPersistor
    */
    public function __construct(
    $name, $primaryFieldName, $requestFieldName, array $meta = [], array $data = [], CollectionFactory $pageCollectionFactory, DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $pageCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Javra\Javraevents\Model\Post $post */
        foreach ($items as $post) {
            $this->loadedData[$post->getId()] = $post->getData();
        }

        $data = $this->dataPersistor->get('javra_events');
        if (!empty($data)) {
            $block = $this->collection->getNewEmptyItem();
            $block->setData($data);
            $this->loadedData[$post->getId()] = $post->getData();
            $this->dataPersistor->clear('javra_events');
        }

        return $this->loadedData;
    }

}