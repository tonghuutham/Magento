<?php

namespace Magenest\Movie\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form\Element\DataType\Price;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

class CourseMaterial extends AbstractModifier
{
    const FIELD_IS_DELETE = 'is_delete';
    const FIELD_SORT_ORDER_NAME = 'sort_order';
    /**
     * @var LocatorInterface
     */
    private $locator;

    public function __construct(
        LocatorInterface $locator
    ) {
        $this->locator = $locator;
    }

    public function modifyData(array $data)
    {
        $fieldCode = 'supplier_fieldset';

        $model = $this->locator->getProduct();
        $modelId = $model->getId();

        $data[$modelId]['product'][$fieldCode]['supplier_field'] = [
            [
                'record_id' => 0,
                'supplier' => 'supplier1',
                'cost_price' => '22',
                'sell_price' => '44',
            ],
            [
                'record_id' => 1,
                'supplier' => 'supplier2',
                'cost_price' => '2',
                'sell_price' => '1',
            ]
        ];

        return $data;
    }

    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'supplier_fieldset' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Course Material'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.product.supplier_fieldset',
                                'collapsible' => true,
                                'sortOrder' => 5,
                            ],
                        ],
                    ],
                    'children' => [
                        "supplier_field" => $this->getSelectTypeGridConfig(10)
                    ],
                ]
            ]
        );

        return $meta;
    }

    protected function getSelectTypeGridConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'addButtonLabel' => __('Add Course'),
                        'componentType' => DynamicRows::NAME,
                        'component' => 'Magento_Ui/js/dynamic-rows/dynamic-rows',
                        'additionalClasses' => 'admin__field-wide',
                        'deleteProperty' => static::FIELD_IS_DELETE,
                        'deleteValue' => '1',
                        'renderDefaultRecord' => false,
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
            'children' => [
                'record' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Container::NAME,
                                'component' => 'Magento_Ui/js/dynamic-rows/record',
                                'positionProvider' => static::FIELD_SORT_ORDER_NAME,
                                'isTemplate' => true,
                                'is_collection' => true,
                            ],
                        ],
                    ],
                    'children' => [
                        'supplier' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'formElement' => Select::NAME,
                                        'componentType' => Field::NAME,
                                        'dataType' => Text::NAME,
                                        'dataScope' => 'supplier',
                                        'label' => __(' Name'),
                                        'options' => [
                                            [
                                                'label' => __('Course 1'),
                                                'value' => 'supplier1'
                                            ],
                                            [
                                                'label' => __('Course 2'),
                                                'value' => 'supplier2'
                                            ]
                                        ],
                                        'value' => 0,
                                        'sortOrder' => 20,
                                    ],
                                ],
                            ],
                        ],
                        'cost_price' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'componentType' => Field::NAME,
                                        'formElement' => Input::NAME,
                                        'dataType' => Price::NAME,
                                        'label' => __('Course Price'),
                                        'enableLabel' => true,
                                        'dataScope' => 'cost_price',
                                        'sortOrder' => 40,
                                        'validation' => [
                                            'required-entry' => true,
                                            'validate-greater-than-zero' => true,
                                            'validate-number' => true,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'sell_price' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'componentType' => Field::NAME,
                                        'formElement' => Input::NAME,
                                        'dataType' => Price::NAME,
                                        'label' => __('Sell Price'),
                                        'enableLabel' => true,
                                        'dataScope' => 'sell_price',
                                        'sortOrder' => 40,
                                        'validation' => [
                                            'required-entry' => true,
                                            'validate-greater-than-zero' => true,
                                            'validate-number' => true,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'actionDelete' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'componentType' => 'actionDelete',
                                        'dataType' => Text::NAME,
                                        'label' => '',
                                        'sortOrder' => 50,
                                    ],
                                ],
                            ],
                        ],
                    ]
                ]
            ]
        ];
    }
}
