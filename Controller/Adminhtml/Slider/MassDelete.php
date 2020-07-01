<?php



namespace GeorgeD\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use GeorgeD\Slider\Model\ResourceModel\Slider\CollectionFactory as SliderCollectionFactory;
/**
 * Class MassDelete
 */
class MassDelete extends Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var SliderCollectionFactory
     */
    protected $sliderCollectionFactory;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param Filter $filter
     * @param SliderCollectionFactory $sliderCollectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        SliderCollectionFactory $sliderCollectionFactory
    ) {
        $this->filter = $filter;
        $this->sliderCollectionFactory = $sliderCollectionFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->sliderCollectionFactory->create());

        $sliderDeleted = 0;
        foreach ($collection->getItems() as $slider) {
            $slider->delete();
            $sliderDeleted++;
        }
        $this->messageManager->addSuccess(
            __('Total of %1 record(s) were removed from the slider table.', $sliderDeleted)
        );

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}
