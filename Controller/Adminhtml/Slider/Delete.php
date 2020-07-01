<?php

namespace GeorgeD\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use GeorgeD\Slider\Model\SliderRepository;

/**
 * Class Delete
 * @package GeorgeD\Slider\Controller\Adminhtml\Slider
 */
class Delete extends Action
{

    //    const ADMIN_RESOURCE = 'GeorgeD_Slider_Slider::delete';

    /**
     * @var SliderRepository
     */
    protected $sliderRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param SliderRepository $sliderRepository
     */
    public function __construct(
        Context $context,
        SliderRepository $sliderRepository
    )
    {
        $this->sliderRepository = $sliderRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        // check if we know what should be deleted
        if (!$id) {
            // display error message
            $this->messageManager->addErrorMessage(__('We can\'t find a slider to delete.'));
            // go to grid
            return $resultRedirect->setPath('*/*/');
        }

        try {
            // use repository to deleteById
            $this->sliderRepository->deleteById($id);
            // display success message
            $this->messageManager->addSuccessMessage(__('The slider has been deleted.'));
            // go to grid
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            // display error message
            $this->messageManager->addErrorMessage($e->getMessage());
            // go back to edit form
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
    }
}
