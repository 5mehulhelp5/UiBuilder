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

class Container extends AbstractElement
{
    public function _construct()
    {
        $this->setType('container');
    }

    public function getElementConfig()
    {
        $config = array_replace_recursive([
            'componentType' => \Magento\Ui\Component\Container::NAME,
            'formElement'   => \Magento\Ui\Component\Container::NAME,
            'fieldTemplate' => 'Cytracon_UiBuilder/form/field'
        ], (array) $this->getData('config'));

        return [
            'arguments' => [
                'data' => [
                    'config' => $config
                ]
            ]
        ];
    }
}
