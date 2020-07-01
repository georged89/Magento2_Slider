<?php

namespace GeorgeD\Slider\Controller\Adminhtml\Slider;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use GeorgeD\Slider\Model\SliderFactory;
use GeorgeD\Slider\Model\SliderRepository;

/**
 * Class Edit
 * @package GeorgeD\Slider\Controller\Adminhtml\Slider
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var SliderFactory
     */
    protected $sliderFactory;

    /**
     * @var SliderRepository
     */
    protected $sliderRepository;

    /**
     * Edit constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     * @param SliderFactory $sliderFactory
     * @param SliderRepository $sliderRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        SliderFactory $sliderFactory,
        SliderRepository $sliderRepository
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        $this->sliderFactory = $sliderFactory;
        $this->sliderRepository = $sliderRepository;
        parent::__construct($context);
    }


    /**
     * @return $this|\Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->sliderFactory->create();

        // 2. Initial checking
        if ($id) {
            $model = $this->sliderRepository->getById($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This slider no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('georged_slider_slider_data', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Banner') : __('New Banner'),
            $id ? __('Edit Banner') : __('New Banner')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Sliders'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? 'Edit Banner: ' . $model->getFirstName() : __('New Banner'));

        return $resultPage;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('GeorgeD_AdminhtmlMenu::slider');
        $resultPage->addBreadcrumb(__('Slider'), __('Slider'));
        $resultPage->addBreadcrumb(__('Manage Slider'), __('Manage Slider'));

        return $resultPage;
    }
}
