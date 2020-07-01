<?php

namespace GeorgeD\Slider\Model;

use GeorgeD\Slider\Api\Data\SliderInterface;

/**
 * Class Slider
 * @package GeorgeD\Slider\Model
 */
class Slider extends \Magento\Framework\Model\AbstractModel implements \GeorgeD\Slider\Api\Data\SliderInterface, \Magento\Framework\DataObject\IdentityInterface
{
    /**
     *
     */
    const CACHE_TAG = 'georged_slider_slider';

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->getData(SliderInterface::NAME);
    }

    /**
     * @return mixed
     */
    public function getImageLink()
    {
        return $this->getData(SliderInterface::IMAGE_LINK);
    }

    /**
     * @return mixed
     */
    public function getLinkText()
    {
        return $this->getData(SliderInterface::LINK_TEXT);
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->getData(SliderInterface::IMAGE);
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->getData(SliderInterface::POSITION);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function setName($name)
    {
        return $this->setData(SliderInterface::NAME, $name);
    }

    /**
     * @param $image_link
     * @return mixed
     */
    public function setImageLink($image_link)
    {
        return $this->setData(SliderInterface::IMAGE_LINK, $image_link);
    }

    /**
     * @param $link_text
     * @return mixed
     */
    public function setLinkText($link_text)
    {
        return $this->setData(SliderInterface::LINK_TEXT, $link_text);
    }

    /**
     * @param $image
     * @return mixed
     */
    public function setImage($image)
    {
        return $this->setData(SliderInterface::IMAGE, $image);
    }

    /**
     * @param $position
     * @return mixed
     */
    public function setPosition($position)
    {
        return $this->setData(SliderInterface::POSITION, $position);
    }

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('GeorgeD\Slider\Model\ResourceModel\Slider');
    }

}
