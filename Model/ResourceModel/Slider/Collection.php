<?php

namespace GeorgeD\Slider\Model\ResourceModel\Slider;

/**
 * Class Collection
 * @package GeorgeD\Slider\Model\ResourceModel\Slider
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('GeorgeD\Slider\Model\Slider', 'GeorgeD\Slider\Model\ResourceModel\Slider');
    }
}
