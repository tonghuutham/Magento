<?php declare(strict_types=1);

use Magento\Cms\Block\Adminhtml\Page\Widget\Chooser;
use Magento\Cms\Block\Widget\Page\Link;

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
return [
    '@' => ['type' => Link::class, 'module' => 'Magento_Cms'],
    'name' => 'CMS Movie Account',
    'description' => 'Account to a CMS Movie',
    'is_email_compatible' => '1',
    'placeholder_image' => 'Magento_Cms::images/widget_page_link.png',
    'parameters' => [
        'page_id' => [
            '@' => ['type' => 'complex'],
            'type' => 'label',
            'helper_block' => [
                'type' => Chooser::class,
                'data' => ['button' => ['open' => 'Select Movie...']],
            ],
            'visible' => '1',
            'required' => '1',
            'sort_order' => '10',
            'label' => 'CMS Movie',
        ],
        'anchor_text' => [
            'type' => 'text',
            'visible' => '1',
            'label' => 'Anchor Custom Text',
            'description' => 'If empty, the Movie Title will be used',
            'depends' => ['show_pager' => ['value' => '1']],
        ],
        'template' => [
            'type' => 'select',
            'values' => [
                'default' => [
                    'value' => 'product/widget/link/link_block.phtml',
                    'label' => 'Product Account Block Template',
                ],
                'link_inline' => [
                    'value' => 'product/widget/link/link_inline.phtml',
                    'label' => 'Product Account Inline Template',
                ],
            ],
            'visible' => '1',
            'label' => 'Template',
            'value' => 'product/widget/link/link_block.phtml',
        ],
    ],
    'supported_containers' => [
        '0' => [
            'container_name' => 'left',
            'template' => ['default' => 'default', 'names_only' => 'link_inline'],
        ],
        '1' => ['container_name' => 'content', 'template' => ['grid' => 'default', 'list' => 'list']],
    ]
];
