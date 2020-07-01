<?php

namespace GeorgeD\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use GeorgeD\Slider\Api\Data\SliderInterface;
use GeorgeD\Slider\Model\Slider;
use GeorgeD\Slider\Model\SliderFactory;
use GeorgeD\Slider\Model\SliderRepository;

/**
 * Class Save
 * @package GeorgeD\Slider\Controller\Adminhtml\Slider
 */
class Save extends Action
{
    /**
     * @var SliderFactory
     */
    protected $_sliderFactory;

    /**
     * @var SliderRepository
     */
    protected $_sliderRepository;

    /**
     * @var SliderInterface
     */
    protected $_sliderInterface;

    /**
     * @var DataObjectHelper
     */
    protected $_dataObjectHelper;

    protected $_genericUploader;
    
    /**
     * Save constructor.
     * @param Context $context
     * @param DataObjectHelper $_dataObjectHelper
     * @param SliderFactory $_sliderFactory
     * @param SliderRepository $_sliderRepository
     * @param SliderInterface $_sliderInterface
     */
    public function __construct(
        Context $context,
        DataObjectHelper $_dataObjectHelper,
        SliderFactory $_sliderFactory,
        SliderRepository $_sliderRepository,
        SliderInterface $_sliderInterface,
        \GeorgeD\Slider\Model\GenericUploader $_genericUploader
    )
    {
        $this->_dataObjectHelper = $_dataObjectHelper;
        $this->_sliderFactory = $_sliderFactory;
        $this->_sliderRepository = $_sliderRepository;
        $this->_sliderInterface = $_sliderInterface;
        $this->_genericUploader = $_genericUploader;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /** @var \GeorgeD\Slider\Api\Data\SliderInterface $slider */
        $slider = null;

        $data = $this->getRequest()->getPostValue();

        $id = !empty($data['entity_id']) ? $data['entity_id'] : null;

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$data) {
            $resultRedirect->setPath('slider/slider/edit', ['entity_id' => $id]);
            return $resultRedirect;
        }


        try {
            if ($id) {
                /** @var SliderInterface $slider */
                $slider = $this->_sliderRepository->getById($id);
            } else {
                /** @var Slider $slider */
                $slider = $this->_sliderFactory->create();
            }

            $img = isset($data['image'][0]) ? $data['image'][0] : false;

            if(isset($img['name'])){
//                unset($data['image']);
                $imageLogo = $this->getUploader('image')->uploadFileAndGetName('image', $data);
                $data['image'] = $imageLogo;
            }elseif(isset($img['image'])){
                $data['image']=$data['image'][0]['image'];
            }



            /** populate $model with the $data array */
            $this->_dataObjectHelper->populateWithArray($slider, $data, SliderInterface::class);

            /** use the SliderRepository to save the data. */
            $slider = $this->_sliderRepository->save($slider);

            $this->messageManager->addSuccessMessage(__('You saved the Slider'));

            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('slider/slider/edit', ['entity_id' => $slider->getId()]);
            } else {
                $resultRedirect->setPath('slider/slider/index');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            /** set post data to session so we have the form populated after redirect. */
            $this->_getSession()->setGeorgeDSliderSliderData($data);

            /** do redirect to edit form */
            $resultRedirect->setPath('slider/slider/edit', ['entity_id' => $id]);
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Slider.'));
            /** set post data to session so we have the form populated after redirect. */
            $this->_getSession()->setGeorgeDSliderSliderData($data);

            /** do redirect to edit form */
            $resultRedirect->setPath('slider/slider/edit', ['entity_id' => $id]);
        }

        return $resultRedirect;
    }

    /**
     * @param $type
     * @return \GeorgeD\Slider\Model\Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->_genericUploader->getUploader($type);
    }
}
