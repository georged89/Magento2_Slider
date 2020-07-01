<?php

namespace GeorgeD\Slider\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use  GeorgeD\Slider\Model\Image;

/**
 * Class Thumbnail
 * @package GeorgeD\Slider\Ui\Component\Listing\Column
 */
class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var Image\Image
     */
    protected $image;

    /**
     * Thumbnail constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Image\Image $image
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Image\Image $image,
        array $components = [],
        array $data = []
    ) {
        $this->image = $image;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if(isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $path = $this->image->getBaseUrl();
            foreach ($dataSource['data']['items'] as & $item) {
                if($item['image']){
                    $item[$fieldName . '_src'] = [$path.$item['image']];
                    $item[$fieldName . '_alt'] = $item['name'].' - '.$item['link_text'];
                    $item[$fieldName . '_orig_src'] = $path.$item['image'];
                }
            }
        }


        return $dataSource;
    }
}