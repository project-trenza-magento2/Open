<?php
namespace Trenza\Message\Block\Adminhtml\Message;

/**
 * Adminhtml news pages grid
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magentostudy\News\Model\ResourceModel\News\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magentostudy\News\Model\News
     */
    protected $_news;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magentostudy\News\Model\News $news
     * @param \Magentostudy\News\Model\ResourceModel\News\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Trenza\Message\Model\Message $news,
        \Trenza\Message\Model\ResourceModel\Message\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_news = $news;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('messageGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        /* @var $collection \Magentostudy\News\Model\ResourceModel\News\Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare columns
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', [
            'header'    => __('ID'),
            'index'     => 'id',
        ]);
        

        $this->addColumn('product_id', ['header' => __('Product Id'), 'index' => 'product_id',
            'type' => 'action',
            'actions' => [
                    [
                        'caption' => __('Product Link'),
                        'type' => 'action',
                        'getter' => 'getProductId',
                        'url' => [
                            'base' => 'catalog/product/edit/id/',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'id',
                        'renderer'  => 'Trenza_Message_Block_Adminhtml_Template_Grid_Renderer_Myrenderedtwo'
                    ]
                ]
            ]
        );

        $this->addColumn('message', ['header' => __('Message'), 'index' => 'message',]);

        //$this->addColumn('sender_id', ['header' => __('Sender Id'), 'index' => 'sender_id']);

        $this->addColumn('sender_link', ['header' => __('Sender Link'), 'index' => 'sender_id',
            'type' => 'action',
            'actions' => [
                    [
                        'caption' => __('Sender Link'),
                        'type' => 'action',
                        'getter' => 'getSenderId',
                        'url' => [
                            'base' => 'customer/index/edit',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'id',
                        //Trenza\Message\Block\Adminhtml\Message
                        'renderer'  => 'Trenza_Message_Block_Adminhtml_Template_Grid_Renderer_Myrendered'
                    ]
                ]
            ]
        );

        //$this->addColumn('reciver_id', ['header' => __('Receiver Id'), 'index' => 'receiver_id']);
        $this->addColumn('reciver_link', ['header' => __('Receiver Link'), 'index' => 'receiver_id',
            'type' => 'action',
            'actions' => [
                    [
                        'caption' => __('Reciver Link'),
                        'type' => 'action',
                        'getter' => 'getReceiveId',
                        'url' => [
                            'base' => 'customer/index/edit',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'id',
                        //Trenza\Message\Block\Adminhtml\Message
                        'renderer'  => 'Trenza_Message_Block_Adminhtml_Template_Grid_Renderer_Myrenderedone'
                    ]
                ]
            ]
        );
  
        
        
        $this->addColumn(
            'action',
            [
                'header' => __('Delete'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Delete'),
                        'url' => [
                            'base' => '*/*/delete',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'id'
                    ]
                ],
                'sortable' => false,
                'filter' => false,
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @param \Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/grid', ['id' => $row->getId()]);
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
