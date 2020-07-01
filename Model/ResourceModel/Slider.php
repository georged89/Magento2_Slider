<?php


namespace GeorgeD\Slider\Model\ResourceModel;

/**
 * Class Slider
 * @package GeorgeD\Slider\Model\ResourceModel
 */
class Slider extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('georged_slider', 'entity_id');
    }

}
