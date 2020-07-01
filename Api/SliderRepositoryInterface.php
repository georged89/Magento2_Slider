<?php
namespace GeorgeD\Slider\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use \GeorgeD\Slider\Api\Data\SliderInterface;

/**
 * Interface SliderRepositoryInterface
 * @package GeorgeD\Slider\Api
 */
interface SliderRepositoryInterface
{
    /**
     * @param \GeorgeD\Slider\Api\Data\SliderInterface $slider
     * @return \GeorgeD\Slider\Api\Data\SliderInterface
     */
    public function save(SliderInterface $slider);

    /**
     * @param int $id
     * @return \GeorgeD\Slider\Api\Data\SliderInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException;
     */
    public function getById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * @param \GeorgeD\Slider\Api\Data\SliderInterface $slider
     * @return mixed
     */
    public function delete(SliderInterface $slider);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteById($id);

}
