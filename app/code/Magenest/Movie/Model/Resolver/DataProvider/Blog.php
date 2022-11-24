<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Movie\Model\Resolver\DataProvider;

use Magenest\Movie\Api\BlogRepositoryInterface;
use Magenest\Movie\Api\Data\BlogInterface;
use Magenest\Movie\Api\GetBlogByIdentifierInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Widget\Model\Template\FilterEmulate;

/**
 * Movie Blog data provider
 */
class Blog
{
    /**
     * @var GetBlogByIdentifierInterface
     */
    private $blogByIdentifier;

    /**
     * @var BlogRepositoryInterface
     */
    private $blogRepository;

    /**
     * @var FilterEmulate
     */
    private $widgetFilter;

    /**
     * @param BlogRepositoryInterface $blogRepository
     * @param FilterEmulate $widgetFilter
     * @param GetBlogByIdentifierInterface $getblogByIdentifier
     */
    public function __construct(
        BlogRepositoryInterface $blogRepository,
        FilterEmulate $widgetFilter,
        GetBlogByIdentifierInterface $getblogByIdentifier
    ) {
        $this->blogRepository = $blogRepository;
        $this->widgetFilter = $widgetFilter;
        $this->blogByIdentifier = $getblogByIdentifier;
    }
    /**
     * Returns blog data by blog_id
     *
     * @param int $blogId
     * @return array
     * @throws NoSuchEntityException
     */
    public function getDataByBlogId(int $blogId): array
    {
        $blog = $this->blogRepository->getById($blogId);

        return $this->convertBlogData($blog);
    }
    /**
     * Convert blog data
     *
     * @param BlogInterface $blog
     * @return array
     * @throws NoSuchEntityException
     */
    private function convertBlogData(BlogInterface $blog)
    {
//        if (false === $blog->isActive()) {
//            throw new NoSuchEntityException();
//        }

        $renderedAuthorId = $this->widgetFilter->filter($blog->getAuthorId());
        $blogData = [
            BlogInterface::AUTHOR_ID => $renderedAuthorId,
            BlogInterface::TITLE => $blog->getTitle(),
            BlogInterface::DESCRIPTION => $blog->getDescription(),
            BlogInterface::CONTENT => $blog->getContent(),
            BlogInterface::URL_REWRITE => $blog->getUrlRewrite(),
            BlogInterface::STATUS => $blog->getStatus(),
            BlogInterface::CREATE_AT => $blog->getCreateAt(),
            BlogInterface::UPDATE_AT => $blog->getUpdateAt(),
        ];
        return $blogData;
    }

    /**
     * Returns blog data by blog identifier
     *
     * @param string $blogAuthorId
     * @param int $storeId
     * @return array
     * @throws NoSuchEntityException
     */
    public function getDataByBlogAuthorId(string $blogAuthorId, int $storeId): array
    {
        $blog = $this->blogByIdentifier->execute($blogAuthorId, $storeId);

        return $this->convertBlogData($blog);
    }
}
