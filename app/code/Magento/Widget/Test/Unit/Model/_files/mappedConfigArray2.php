<?php declare(strict_types=1);

use Magento\Cms\Block\Widget\Page\Link;
use Magento\Cms\Model\Config\Source\Page;

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
return [
    '@' => ['type' => Link::class, 'module' => 'Magento_Cms'],
    'name' => 'CMS Account 2',
    'description' => 'Second Account Example',
    'parameters' => [
        'types' => [
            'type' => 'multiselect',
            'visible' => '1',
            'source_model' => Page::class,
        ],
    ]
];
