<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_FormBuilder
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\FormBuilder\Model\Form\Source;

use Magento\Framework\Option\ArrayInterface;

class Formlist implements ArrayInterface
{
 
    /**
     * @var string
     */
    protected $collectionFactory;
    
    /**
     * @param    \Webkul\FormBuilder\Model\FormFactory $collectionFactory
     */
    public function __construct(
        \Webkul\FormBuilder\Model\FormFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->collectionFactory->create()->getCollection();
        $collection->addFieldToFilter('status', 1);
        $ret = [];
        foreach ($collection as $form) {
            $ret[] = [
                'value' => $form->getEntityId(),
                'label' => $form->getName(),
            ];
        }

        return $ret;
    }
}
