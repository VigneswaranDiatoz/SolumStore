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

class ViewResponse extends \Magento\Framework\View\Element\Template
{
   /**
    * @var coreRegistry
    */
    protected $coreRegistry;

   /**
    * @var ResponseFactory
    */
    protected $ResponseFactory;

   /**
    * @var helper
    */
    protected $helper;

   /**
    * @param    \Magento\Backend\Block\Widget\Context       $context
    * @param    \Magento\Framework\Registry                 $coreRegistry
    * @param    \Webkul\FormBuilder\Model\ResponseFactory   $ResponseFactory
    * @param    \Webkul\FormBuilder\Helper\Data             $helper
    * @param    array                                       $data = []
    */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Webkul\FormBuilder\Model\ResponseFactory $ResponseFactory,
        \Webkul\FormBuilder\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->responseFactory = $ResponseFactory;
        $this->coreRegistry = $coreRegistry;
        $this->helper= $helper;
    }
    /**
     * Get Reponse Details By ID
     *
     * @return string
     */
    public function getFormInfoById()
    {
        $id = $this->coreRegistry->registry('entity_id');
        $form = $this->responseFactory->create();
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

    /**
     * Get UserName By ID
     *
     * @param int $id
     * @return string
     */
    public function getUserNameById($id)
    {
        return  $this->helper->getUserNameById($id);
    }

    /**
     * Get Store Name By ID
     *
     * @param int $id
     * @return string
     */
    public function getStoreNameById($id)
    {
        return  $this->helper->getStoreNameById($id);
    }
        
    /**
     * Get Media
     *
     * @return string
     */
    public function getMediaPath()
    {
        return $this->helper->getMediaPath();
    }
    
    /**
     * Function getTimeAccordingToTimeZone
     *
     * @param string $dateTime
     * @return string $dateTime as time zone
     */
    public function getTimeAccordingToTimeZone($dateTime)
    {
        return $this->helper->getTimeAccordingToTimeZone($dateTime);
    }

    /**
     * Json Decode
     *
     * @param array $arr
     * @return Boolen
     */
    public function jsonDecode($arr)
    {
        return $this->helper->jsonDecode($arr);
    }
}
