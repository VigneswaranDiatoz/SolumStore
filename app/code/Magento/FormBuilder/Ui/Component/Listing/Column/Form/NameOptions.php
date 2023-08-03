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
namespace Webkul\FormBuilder\Ui\Component\Listing\Column\Form;

use Magento\Framework\Data\OptionSourceInterface;
use Webkul\FormBuilder\Model\ResourceModel\Form\CollectionFactory;

class NameOptions implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get options into array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $options = $this->collectionFactory->create()->toOptionArray();

            array_walk($options, function (&$option) {
                $option['__disableTmpl'] = true;
            });

            $this->options = $options;
        }

        return $this->options;
    }
}
