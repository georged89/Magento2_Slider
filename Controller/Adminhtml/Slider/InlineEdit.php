<?php

namespace GeorgeD\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use GeorgeD\Slider\Api\Data\SliderInterface;
use GeorgeD\Slider\Api\SliderRepositoryInterface;
use GeorgeD\Slider\Api\SliderRepositoryInterface as SliderRepository;
use GeorgeD\Slider\Model\ResourceModel\Slider as SliderResourceModel;

/**
 * Class InlineEdit
 * @package GeorgeD\Slider\Controller\Adminhtml\Slider
 */
class InlineEdit extends Action
{
    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var SliderRepositoryInterface
     */
    protected $sliderRepository;

    /**
     * @var SliderResourceModel
     */
    protected $sliderResourceModel;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param SliderRepository $sliderRepository
     * @param SliderResourceModel $sliderResourceModel
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PageFactory $resultPageFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        SliderRepository $sliderRepository,
        SliderResourceModel $sliderResourceModel,
        JsonFactory $jsonFactory
    )
    {
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->sliderRepository = $sliderRepository;
        $this->sliderResourceModel = $sliderResourceModel;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];


        $postItems = $this->getRequest()->getParam('items', []);



        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }


        foreach (array_keys($postItems) as $sliderId) {

            $slider = $this->sliderRepository->getById($sliderId);
            try {
                $sliderData = array_merge($slider->getData(), $postItems[$sliderId]);
                /** Validate post data */
                $this->validatePost($sliderData, $slider, $error, $messages);
                $this->dataObjectHelper->populateWithArray($slider, $sliderData, SliderInterface::class);
                $this->sliderRepository->save($slider);
            } catch (LocalizedException $ex) {
                $messages[] = $this->getErrorMessage($slider, $ex->getMessage());
                $error = true;
            } catch (\RuntimeException $ex) {
                $messages[] = $this->getErrorMessage($slider, $ex->getMessage());
                $error = true;
            } catch (\Exception $ex) {
                $messages[] = $this->getErrorMessage(
                    $slider,
                    __('Something went wrong while saving the slider.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }


    /**
     * @param array $data
     * @param \GeorgeD\Slider\Model\Slider $slider
     * @param $error
     * @param array $messages
     */
    protected function validatePost(array $data, \GeorgeD\Slider\Model\Slider $slider, &$error, array &$messages)
    {
        if (!($this->validateRequireEntry($data))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorMessage($slider, $error->getText());
            }
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'name' => __('Name'),
        ];
        $errors = true;

        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errors = false;
                $this->messageManager->addErrorMessage(
                    __('To apply changes you should fill in required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errors;
    }

    /**
     * @param \GeorgeD\Slider\Model\Slider $slider
     * @param $message
     * @return string
     */
    private function getErrorMessage(\GeorgeD\Slider\Model\Slider $slider, $message)
    {
        return '[Slider ID: ' . $slider->getId() . '] ' . $message;
    }
}
