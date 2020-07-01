<?php

namespace GeorgeD\Slider\Model\Image;

use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Image
 * @package GeorgeD\Slider\Model\Image
 */
class Image
{
    /**
     * media sub folder
     * @var string
     */
    protected $subDir = 'georged/slider/image';

    /**
     * url builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $fileSystem;


    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @param UrlInterface $urlBuilder
     * @param Filesystem $fileSystem
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Filesystem $fileSystem,
        DirectoryList $directoryList
    )
    {
        $this->directoryList = $directoryList;
        $this->urlBuilder = $urlBuilder;
        $this->fileSystem = $fileSystem;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getBasePath()
    {
        return $this->directoryList->getPath('media') . '/' . $this->subDir . '/image/';
    }

    /**
     * get images base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->subDir . '/image/';
    }
}