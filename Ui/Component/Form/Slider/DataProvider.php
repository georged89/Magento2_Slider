<?php

namespace GeorgeD\Slider\Ui\Component\Form\Slider;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use GeorgeD\Slider\Model\ResourceModel\Slider\CollectionFactory;
use  GeorgeD\Slider\Model\Image\Image;

/**
 * Class DataProvider
 * @package GeorgeD\Slider\Ui\Component\Form\Slider
 */
class DataProvider extends AbstractDataProvider
{

    /**
     * @var
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var
     */
    protected $loadedData;

    /**
     * @var Image
     */
    protected $image;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param Image $image
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Image $image,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
        $this->image = $image;
    }

    /**
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $baseUrl =  $this->image->getBaseUrl();
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var \GeorgeD\Slider\Model\Slider $slider */
        foreach ($items as $slider) {
            $this->loadedData[$slider->getId()] = $slider->getData();
            if($this->loadedData[$slider->getId()] ['image']):
                $img = [];
                $img[0]['image'] = $this->loadedData[$slider->getId()] ['image'];
                $img[0]['url'] = $baseUrl.$this->loadedData[$slider->getId()] ['image'];
                $this->loadedData[$slider->getId()] ['image'] = $img;
            endif;
        }

        $data = $this->dataPersistor->get('georged_slider_slider_data');
        if (!empty($data)) {
            $slider = $this->collection->getNewEmptyItem();
            $slider->setData($data);
            $this->loadedData[$slider->getId()] = $slider->getData();
            $this->dataPersistor->clear('georged_slider_slider_data');
        }

        return $this->loadedData;
    }
}
