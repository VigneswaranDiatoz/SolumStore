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
namespace Webkul\FormBuilder\Block\Adminhtml;

use Magento\Framework\View\Element\Template\Context;

class Response extends \Magento\Framework\View\Element\Template
{
   /**
    * @var coreRegistry
    */
    protected $coreRegistry;

   /**
    * @var FormFactory
    */
    protected $FormFactory;

   /**
    * @var helper
    */
    protected $helper;

   /**
    * @param    \Magento\Backend\Block\Widget\Context   $context
    * @param    \Magento\Framework\Registry             $coreRegistry
    * @param    \Webkul\FormBuilder\Model\FormFactory   $FormFactory
    * @param    \Webkul\FormBuilder\Helper\Data         $helper
    * @param    array                                   $data = []
    */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Webkul\FormBuilder\Model\FormFactory $FormFactory,
        \Webkul\FormBuilder\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->formFactory = $FormFactory;
        $this->coreRegistry = $coreRegistry;
        $this->helper= $helper;
    }
    /**
     * Get form details by id
     *
     * @return string
     */
    public function getFormInfoById()
    {
        $id = $this->coreRegistry->registry('entity_id');
        $form = $this->formFactory->create();
        $result = $form->load($id);
        $result = $result->getData();
        return $result;
    }
    
    /**
     * Get locale code
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->helper->getLocale();
    }
}
