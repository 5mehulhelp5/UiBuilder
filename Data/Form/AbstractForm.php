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

namespace Cytracon\UiBuilder\Data\Form;

use Cytracon\UiBuilder\Data\Form\Element\AbstractElement;
use Cytracon\UiBuilder\Data\Form\Element\Factory;
use Cytracon\UiBuilder\Data\Form\Element\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class AbstractForm extends \Magento\Framework\DataObject
{
    /**
     * Form level elements collection
     *
     * @var Collection
     */
    protected $_elements;

    /**
     * Element type classes
     *
     * @var array
     */
    protected $_types = [];

    /**
     * @var Factory
     */
    protected $_factoryElement;

    /**
     * @var CollectionFactory
     */
    protected $_factoryCollection;

    /**
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param array $data
     */
    public function __construct(Factory $factoryElement, CollectionFactory $factoryCollection, $data = [])
    {
        $this->_factoryElement    = $factoryElement;
        $this->_factoryCollection = $factoryCollection;
        parent::__construct($data);
        $this->_construct();
    }

    /**
     * Internal constructor, that is called from real constructor
     *
     * Please override this one instead of overriding real __construct constructor
     *
     * @return void
     */
    protected function _construct()
    {
    }

    /**
     * Get elements collection
     *
     * @return Collection
     */
    public function getElements()
    {
        if (empty($this->_elements)) {
            $this->_elements = $this->_factoryCollection->create(['container' => $this]);
        }
        return $this->_elements;
    }

    public function addElement(AbstractElement $element)
    {
        $element->setForm($this);
        $this->getElements()->add($element);
        return $this;
    }

    public function addChildren($elementId, $type, $config = [])
    {
        if (isset($this->_types[$type])) {
            $type = $this->_types[$type];
        }

        if (isset($config['required']) && $config['required']) {
            $validation                   = isset($config['validation']) ? $config['validation'] : [];
            $validation['required-entry'] = true;
            $config['validation']         = $validation;
        }

        $element = $this->_factoryElement->create($type, ['data' => ['config' => $config]]);
        $element->setId($elementId);
        $this->addElement($element);
        return $element;
    }

    public function addFieldset($elementId, $config = [])
    {
        $element = $this->_factoryElement->create('fieldset', ['data' => ['config' => $config]]);
        $element->setId($elementId);
        $this->addElement($element);
        return $element;
    }

    public function addContainer($elementId, $config = [])
    {
        $element = $this->_factoryElement->create('container', ['data' => ['config' => $config]]);
        $element->setId($elementId);
        $this->addElement($element);
        return $element;
    }

    public function addContainerGroup($elementId, $config = [])
    {
        $element = $this->_factoryElement->create('containerGroup', ['data' => ['config' => $config]]);
        $element->setId($elementId);
        $this->addElement($element);
        return $element;
    }

    /**
     * Convert elements to array
     *
     * @param array $arrAttributes
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToArray(array $arrAttributes = [])
    {
        $res = [];
        $res['config'] = $this->getData();
        $res['formElements'] = [];
        foreach ($this->getElements() as $element) {
            $_data                 = $element->toArray();
            $res['formElements'][] = $_data;
        }
        return $res;
    }

    public function removeField($key)
    {
        $elements = $this->getElements();

        if (!$elements->searchById($key)) {
            throw new \Exception(__('Element name %1 not exist', $key));
        }
        $elements->remove($key);
        return $this;
    }
}
