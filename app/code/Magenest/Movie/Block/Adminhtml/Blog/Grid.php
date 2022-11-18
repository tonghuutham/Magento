<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Block\Adminhtml\Blog;

/**
 * adminhtml movie movie grid
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magenest\Movie\Model\ResourceModel\Blog\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magenest\Movie\Model\Blog
     */
    protected $_movieMovie;

    /**
     * @var \Magento\Framework\View\Model\MovieLayout\Config\BuilderInterface
     */
    protected $movieLayoutBuilder;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magenest\Movie\Model\Blog $movieMovie
     * @param \Magenest\Movie\Model\ResourceModel\Blog\CollectionFactory $collectionFactory
     * @param \Magento\Framework\View\Model\MovieLayout\Config\BuilderInterface $movieLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magenest\Movie\Model\Blog $movieMovie,
        \Magenest\Movie\Model\ResourceModel\Blog\CollectionFactory $collectionFactory,
        \Magento\Framework\View\Model\MovieLayout\Config\BuilderInterface $movieLayoutBuilder,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_movieMovie = $movieMovie;
        $this->movieLayoutBuilder = $movieLayoutBuilder;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('movieMovieGrid');
        $this->setDefaultSort('identifier');
        $this->setDefaultDir('ASC');
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        /* @var $collection \Magenest\Movie\Model\ResourceModel\Blog\Collection */
        $collection->setFirstStoreFlag(true);
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

//        $this->addColumn('title', ['header' => __('Title'), 'index' => 'title']);
//
//        $this->addColumn('identifier', ['header' => __('URL Key'), 'index' => 'identifier']);
//
//        $this->addColumn(
//            'movie_layout',
//            [
//                'header' => __('Layout'),
//                'index' => 'movie_layout',
//                'type' => 'options',
//                'options' => $this->movieLayoutBuilder->getMovieLayoutsConfig()->getOptions()
//            ]
//        );

        /**
         * Check is single store mode
         */
        if (!$this->_storeManager->isSingleStoreMode()) {
            $this->addColumn(
                'id',
                [
                    'header' => __('Store View'),
                    'index' => 'id',
                    'type' => 'movie',
//                    'store_all' => true,
//                    'store_view' => true,
//                    'sortable' => false,
                    'filter_condition_callback' => [$this, '_filterStoreCondition']
                ]
            );
        }

        $this->addColumn(
            'name',
            [
                'header' => __('Status'),
                'index' => 'name',
                'type' => 'options',
                'options' => $this->_movieMovie->getAvailableStatuses()
            ]
        );

        $this->addColumn(
            'description',
            [
                'header' => __('description'),
                'index' => 'description',
            ]
        );

        $this->addColumn(
            'rating',
            [
                'header' => __('Modified'),
                'index' => 'rating',

            ]
        );

        $this->addColumn(
            'director_id',
            [
                'header' => __('Action'),
                'index' => 'director_id',

                'renderer' => \Magenest\Movie\Block\Adminhtml\Blog\Grid\Renderer\Action::class,

            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * After load collection
     *
     * @return void
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * Filter store condition
     *
     * @param \Magento\Framework\Data\Collection $collection
     * @param \Magento\Framework\DataObject $column
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _filterStoreCondition($collection, \Magento\Framework\DataObject $column)
    {
        if (!($value = $column->getFilter()->getValue())) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

    /**
     * Row click url
     *
     * @param \Magento\Framework\DataObject $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['id' => $row->getId()]);
    }
}
