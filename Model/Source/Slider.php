<?php

namespace GeorgeD\Slider\Model\Source;

use GeorgeD\Slider\Api\Data\SliderInterface;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;
use GeorgeD\Slider\Model\ResourceModel\Slider\CollectionFactory;

/**
 * Class Slider
 * @package GeorgeD\Slider\Model\Source
 */
class Slider extends AbstractSource implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var null
     */
    protected $collection = null;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;


    /**
     * Field constructor.
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        return $this->toOptionArray();
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if (!empty($this->options)) {
            return $this->options;
        }

        /** @var \GeorgeD\Slider\Model\Slider $slider */
        foreach ($this->getSliderCollection() as $slider) {
            $this->options[] = [
                'label' => $slider->getName(),
                'value' => $slider->getId(),
            ];
        }
        return $this->options;
    }

    /**
     * @return null
     */
    public function getSliderCollection()
    {
        if ($this->collection !== null) {
            return $this->collection;
        }

        /** @var \GeorgeD\Slider\Model\ResourceModel\Slider\Collection collection */
        $this->collection = $this->collectionFactory->create()
            ->setOrder(SliderInterface::POSITION, 'ASC');

        return $this->collection;
    }
}
