<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magenest\Movie\Model\BlogRepository\Validator;

use Magenest\Movie\Api\Data\BlogInterface;
use Magenest\Movie\Model\BlogRepository\ValidatorInterface;
use Magento\Framework\Config\Dom\ValidationException;
use Magento\Framework\Config\Dom\ValidationSchemaException;
use Magento\Framework\Config\ValidationStateInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Model\Layout\Update\Validator;
use Magento\Framework\View\Model\Layout\Update\ValidatorFactory;

/**
 * Validate a given page
 */
class LayoutUpdateValidator implements ValidatorInterface
{
    /**
     * @var ValidatorFactory
     */
    private $validatorFactory;

    /**
     * @var ValidationStateInterface
     */
    private $validationState;

    /**
     * @param ValidatorFactory $validatorFactory
     * @param ValidationStateInterface $validationState
     */
    public function __construct(
        ValidatorFactory         $validatorFactory,
        ValidationStateInterface $validationState
    ) {
        $this->validatorFactory = $validatorFactory;
        $this->validationState = $validationState;
    }

    /**
     * Validate the data before saving
     *
     * @param BlogInterface $blog
     * @throws LocalizedException
     */
    public function validate(BlogInterface $blog): void
    {
        $this->validateRequiredFields($blog);
        $this->validateLayoutUpdate($blog);
        $this->validateCustomLayoutUpdate($blog);
    }

    /**
     * Validate required fields
     *
     * @param BlogInterface $blog
     * @throws LocalizedException
     */
    private function validateRequiredFields(BlogInterface $blog): void
    {
        if (empty($blog->getTitle())) {
            throw new LocalizedException(__('Required field "%1" is empty.', 'title'));
        }
    }

    /**
     * Validate layout update
     *
     * @param BlogInterface $blog
     * @throws LocalizedException
     */
    private function validateLayoutUpdate(BlogInterface $blog): void
    {
        $layoutXmlValidator = $this->getLayoutValidator();

        try {
            if (!empty($blog->getLayoutUpdateXml())
                && !$layoutXmlValidator->isValid($blog->getLayoutUpdateXml())
            ) {
                throw new LocalizedException(__('Layout update is invalid'));
            }
        } catch (ValidationException|ValidationSchemaException $e) {
            throw new LocalizedException(__('Layout update is invalid'));
        }
    }

    /**
     * Return a new validator
     *
     * @return Validator
     */
    private function getLayoutValidator(): Validator
    {
        return $this->validatorFactory->create(
            [
                'validationState' => $this->validationState,
            ]
        );
    }

    /**
     * Validate custom layout update
     *
     * @param BlogInterface $blog
     * @throws LocalizedException
     */
    private function validateCustomLayoutUpdate(BlogInterface $blog): void
    {
        $layoutXmlValidator = $this->getLayoutValidator();

        try {
            if (!empty($blog->getCustomLayoutUpdateXml())
                && !$layoutXmlValidator->isValid($blog->getCustomLayoutUpdateXml())
            ) {
                throw new LocalizedException(__('Custom layout update is invalid'));
            }
        } catch (ValidationException|ValidationSchemaException $e) {
            throw new LocalizedException(__('Custom layout update is invalid'));
        }
    }
}
