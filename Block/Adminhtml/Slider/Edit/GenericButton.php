<?php

namespace GeorgeD\Slider\Block\Adminhtml\Slider\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use GeorgeD\Slider\Api\SliderRepositoryInterface;

/**
 * Class GenericButton
 * @package GeorgeD\Slider\Block\Adminhtml\Slider\Edit
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**@var SliderRepositoryInterface $sliderRepository */
    protected $sliderRepository;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param SliderRepositoryInterface $sliderRepository
     */
    public function __construct(
        Context $context,
        SliderRepositoryInterface $sliderRepository
    )
    {
        $this->context = $context;
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * @return int|null
     */
    public function getSliderId()
    {
        try {
            return $this->sliderRepository->getById(
                $this->context->getRequest()->getParam('entity_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}