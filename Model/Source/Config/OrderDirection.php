<?php

namespace GeorgeD\Slider\Model\Source\Config;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class PositionDirection
 * @package GeorgeD\Slider\Model\Source
 */
class OrderDirection extends AbstractSource implements OptionSourceInterface
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

            $this->options[] = [
                'label' => "Ascending",
                'value' => "ASC",
            ];
        $this->options[] = [
                'label' => "Descending",
                'value' => "DES",
            ];
        return $this->options;
    }


}
