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
namespace Webkul\FormBuilder\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;
use Webkul\FormBuilder\Helper\Data;
use Magento\Framework\UrlInterface;
use Magento\Customer\Model\SessionFactory;

class FormWidget extends Template implements BlockInterface
{

    /**
     * @var helper
     */
    protected $helper;

    /**
     * @var $_template
     */
    protected $_template = "widget/formRender.phtml";

    /**
     * @var $formHelper
     */
    public $formHelper;

    /**
     * @var $urlInterface
     */
    public $urlInterface;

    /**
     * @param    SessionFactory                         $customerSession
     * @param    \Webkul\FormBuilder\Helper\Data        $Data
     * @param    \Magento\Backend\Block\Widget\Context  $context
     * @param    UrlInterface                           $urlInterface
     * @param    array                                  $data = []
     * @param    \Magento\Cms\Helper\Wysiwyg\Images     $wysiwygImages
     */
    public function __construct(
        SessionFactory $customerSession,
        Data $Data,
        Context $context,
        UrlInterface $urlInterface,
        array $data = [],
        \Magento\Cms\Helper\Wysiwyg\Images $wysiwygImages = null
    ) {
        $this->formHelper = $Data;
        $this->urlInterface = $urlInterface;
        $this->customerSession = $customerSession;
        $this->wysiwygImages = $wysiwygImages ?: \Magento\Framework\App\ObjectManager::getInstance()
                                  ->create(\Magento\Cms\Helper\Wysiwyg\Images::class);
        parent::__construct($context, $data);
    }

    /**
     * Get Form Details By ID
     *
     * @param int $id
     * @return array
     */
    public function getFormInfoById($id)
    {
        return $this->formHelper->getFormInfoById($id);
    }

    /**
     * Check Recaptcha Enabled
     *
     * @return Boolen
     */
    public function getFormEnable()
    {
        return $this->formHelper->getFormEnable();
    }

    /**
     * Check Recaptcha Enabled
     *
     * @return Boolen
     */
    public function enableRecaptcha()
    {
        return $this->formHelper->enableRecaptcha();
    }
    
    /**
     * Get Site Key
     *
     * @return Boolen
     */
    public function getSiteKey()
    {
        return $this->formHelper->getSiteKey();
    }

    /**
     * Json Decode
     *
     * @param array $arr
     * @return array
     */
    public function jsonDecode($arr)
    {
        return $this->formHelper->jsonDecode($arr);
    }

    /**
     * Return Field Name value
     *
     * @param array $field
     * @param array $type
     * @return string
     */
    public function nameLabelValue($field, $type)
    {
        if ($field) {
            switch ($field->type) {
                case "checkbox-group":
                    if ($type == "label") {
                        return 'res['.(!empty($field->name) ? $field->name :  $field->type).']['.$type.']';
                    } else {
                        return 'res['.(!empty($field->name) ? $field->name :  $field->type).']['.$type.'][]';
                    }
                    break;
                default:
                    return 'res['.(!empty($field->name) ? $field->name :  $field->type).']['.$type.']';
            }
            
        }
    }

    /**
     * Return get CurrentUrl
     *
     * @return string
     */
    public function getCurrentUrl():string
    {
        return  $this->urlInterface->getCurrentUrl();
    }

     /**
      * Return get BaseUrl
      *
      * @return string
      */
    public function getBaseUrl():string
    {
        return  $this->urlInterface->getBaseUrl();
    }

    /**
     * Function to check that form is enable For a particular form
     *
     * @param string $recaptcha
     * @return bool
     */
    public function checkRecaptcha($recaptcha)
    {
        return $this->formHelper->checkRecaptcha($recaptcha);
    }

    /**
     * Function getWysiwygUrl function
     *
     * @return string
     */
    public function getWysiwygUrl()
    {
        $currentTreePath = $this->wysiwygImages->idEncode(
            \Magento\Cms\Model\Wysiwyg\Config::IMAGE_DIRECTORY
        );
        $url =  $this->getUrl(
            'formbuilder/wysiwyg_images/index',
            [
                'current_tree_path' => $currentTreePath
            ]
        );
        return $url;
    }
}
