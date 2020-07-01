<?php

namespace GeorgeD\Slider\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Store\Model\StoreManagerInterface;
use GeorgeD\Slider\Api\Data\SliderInterfaceFactory;


class Slider extends Template implements BlockInterface
{
    protected $_template = "widget/slider.phtml";

    protected $_sliderFactory;

    protected $_storeManager;
    protected $_scopeConfig;

    public function __construct(
        Template\Context $context,
        array $data = [],
        SliderInterfaceFactory $sliderFactory,
        StoreManagerInterface $storeManager
)
      {
          $this->_sliderFactory = $sliderFactory;
          parent::__construct($context, $data);

          $this->_storeManager = $storeManager;
          $this->_scopeConfig = $context->getScopeConfig();//$scopeConfig;
      }

    public function getSliderData(){

        $collection = $this->_sliderFactory->create()->getCollection();
        $orderDirection = $this->_scopeConfig->getValue('slider/general/order_direction', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $collection->setOrder('position',$orderDirection);
        return $collection;

    }

}
