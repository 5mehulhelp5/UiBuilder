<?php
/**
 * Cytracon
 *
 * This source file is subject to the Cytracon Software License, which is available at https://www.cytracon.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to https://magento.com for more information.
 *
 * @category  Cytracon
 * @package   Cytracon_UiBuilder
 * @copyright Copyright (C) 2018 Cytracon (https://www.cytracon.com)
 */

namespace Cytracon\UiBuilder\Data\Form\Element;

use Magento\Framework\ObjectManagerInterface;

class Factory
{
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * Standard library element types
     *
     * @var array
     */
    protected $_standardTypes = [
        'fieldset',
        'element',
        'container',
        'containerGroup',
        'text',
        'select',
        'boolean',
        'editor',
        'code',
        'textarea',
        'checkbox',
        'radio',
        'image',
        'dynamicRows',
        'date',
        'actionDelete',
        'multiselect',
        'color',
        'tab',
        'html',
        'hidden',
        'button',
        'number'
    ];

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->_objectManager = $objectManager;
    }

    public function create($elementType, array $config = [])
    {
        if (in_array($elementType, $this->_standardTypes)) {
            $className = 'Cytracon\UiBuilder\Data\Form\Element\\' . ucfirst($elementType);
        } else {
            $className = $elementType;
        }
        if (isset($config['default'])) {
            $config['default'] = '';
        }
        $element = $this->_objectManager->create($className, $config);
        if (!$element instanceof \Cytracon\UiBuilder\Data\Form\Element\AbstractElement) {
            $className . ' doesn\'t not extend \Cytracon\UiBuilder\Data\Form\Element\AbstractElement';
        }
        return $element;
    }
}
