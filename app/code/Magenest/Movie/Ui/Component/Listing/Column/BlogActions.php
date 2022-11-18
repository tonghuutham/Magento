<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Ui\Component\Listing\Column;

use Magenest\Movie\Block\Adminhtml\Movie\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class prepare Movie Actions
 */
class BlogActions extends Column
{
    /** Url path */
    const MOVIE_URL_PATH_EDIT = 'magenest_movie/blog/edit';
    const MOVIE_URL_PATH_DELETE = 'magenest_movie/blog/delete';

    /**
     * @var UrlBuilder
     */
    protected $actionUrlBuilder;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var \Magenest\Movie\ViewModel\Movie\Grid\UrlBuilder
     */
    private $scopeUrlBuilder;
    /**
     * @var string
     */
    private $editUrl;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     * @param \Magenest\Movie\ViewModel\Movie\Grid\UrlBuilder|null $scopeUrlBuilder
     */
    public function __construct(
        ContextInterface                                $context,
        UiComponentFactory                              $uiComponentFactory,
        UrlBuilder                                      $actionUrlBuilder,
        UrlInterface                                    $urlBuilder,
        array                                           $components = [],
        array                                           $data = [],
        $editUrl = self::MOVIE_URL_PATH_EDIT,
        \Magenest\Movie\ViewModel\Movie\Grid\UrlBuilder $scopeUrlBuilder = null
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->scopeUrlBuilder = $scopeUrlBuilder ?: ObjectManager::getInstance()
            ->get(\Magenest\Movie\ViewModel\Movie\Grid\UrlBuilder::class);
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $author_id = $this->getData('author_id');
                if (isset($item['id'])) {
                    $item[$author_id]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['id']]),
                        'label' => __('Edit'),
                    ];
                    // title=>author_id
                    $title = $this->getEscaper()->escapeHtml($item['author_id']);

                    $item[$author_id]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::MOVIE_URL_PATH_DELETE, ['id' => $item['id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $title),
                            'message' => __('Are you sure you want to delete a %1 record?', $title),
                        ],
                        'post' => true,
                    ];
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get instance of escaper
     *
     * @return Escaper
     * @deprecated 101.0.7
     */
    private function getEscaper()
    {
        if (!$this->escaper) {
            $this->escaper = ObjectManager::getInstance()->get(Escaper::class);
        }
        return $this->escaper;
    }
}
