<?php


namespace GeorgeD\Slider\Api\Data;

/**
 * Interface SliderInterface
 * @package GeorgeD\Slider\Api\Data
 */
interface SliderInterface
{
    /**
     *
     */
    const ENTITY_ID = 'entity_id';

    /**
     *
     */
    const NAME = 'name';

    /**
     *
     */
    const IMAGE_LINK = 'image_link';

    /**
     *
     */
    const LINK_TEXT = 'link_text';

    /**
     *
     */
    const IMAGE = "image";
    /**
     *
     */
    const CREATED_AT = "created_at";
    /**
     *
     */
    const UPDATED_AT = "updated_at";

    /**
     *
     */
    const POSITION = "position";

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getImage();

    /**
     * @return mixed
     */
    public function getImageLink();

    /**
     * @return mixed
     */
    public function getLinkText();

    /**
     * @return mixed
     */
    public function getPosition();


    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @param $name
     * @return mixed
     */
    public function setName($name);


    /**
     * @param $image
     * @return mixed
     */
    public function setImage($image);

    /**
     * @param $imageLink
     * @return mixed
     */
    public function setImageLink($imageLink);

    /**
     * @param $urlText
     * @return mixed
     */
    public function setLinkText($urlText);

    /**
     * @param $position
     * @return mixed
     */
    public function setPosition($position);

}

