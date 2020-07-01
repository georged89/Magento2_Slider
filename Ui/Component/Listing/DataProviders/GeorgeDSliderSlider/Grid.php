<?php

namespace GeorgeD\Slider\Ui\Component\Listing\DataProviders\GeorgeDSliderSlider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use GeorgeD\Slider\Model\ResourceModel\Slider\CollectionFactory;

/**
 * Class Grid
 * @package GeorgeD\Slider\Ui\Component\Listing\DataProviders\GeorgeDSliderSlider
 */
class Grid extends AbstractDataProvider
{

    /**
     * Grid constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
