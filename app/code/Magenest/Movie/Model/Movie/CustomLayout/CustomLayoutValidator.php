<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Movie\Model\Movie\CustomLayout;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magenest\Movie\Model\MovieRepository;

/**
 * Class for layout update validation
 */
class CustomLayoutValidator
{
    /**
     * @var MovieFactory
     */
    private $movieFactory;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * CustomLayoutValidator constructor.
     * @param MovieRepository $movieFactory
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        MovieRepository $movieFactory,
        ManagerInterface $messageManager
    ) {
        $this->movieFactory = $movieFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * Validates layout update and custom layout update for CMS movie
     *
     * @param array $data
     * @return bool
     * @throws LocalizedException
     */
    public function validate(array $data) : bool
    {
        [$layoutUpdate, $customLayoutUpdate, $oldLayoutUpdate, $oldCustomLayoutUpdate] = $this->getLayoutUpdates($data);
        if (isset($data['movie_id'])) {
            if ($layoutUpdate && $oldLayoutUpdate !== $layoutUpdate
                || $customLayoutUpdate && $oldCustomLayoutUpdate !== $customLayoutUpdate
            ) {
                throw new LocalizedException(__('Custom layout update text cannot be changed, only removed'));
            }
        } else {
            if ($layoutUpdate || $customLayoutUpdate) {
                throw new LocalizedException(__('Custom layout update text cannot be changed, only removed'));
            }
        }
        return true;
    }

    /**
     * Gets movie layout update values
     *
     * @param array $data
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getLayoutUpdates(array $data) : array
    {
        $layoutUpdate = $data['layout_update_xml'] ?? null;
        $customLayoutUpdate = $data['custom_layout_update_xml'] ?? null;
        $oldLayoutUpdate = null;
        $oldCustomLayoutUpdate = null;
        if (isset($data['movie_id'])) {
            $movie = $this->movieFactory->getById($data['movie_id']);
            $oldLayoutUpdate = $movie->getId() ? $movie->getLayoutUpdateXml() : null;
            $oldCustomLayoutUpdate = $movie->getId() ? $movie->getCustomLayoutUpdateXml() : null;
        }

        return [$layoutUpdate, $customLayoutUpdate, $oldLayoutUpdate, $oldCustomLayoutUpdate];
    }
}
