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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;
use Magento\Catalog\Model\Product;

class NewForm extends \Magento\Framework\View\Element\Template
{
    /**
     * @var formKey
     */
    protected $formKey;

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
     * @param    \Magento\Backend\Block\Widget\Context  $context
     * @param    \Magento\Framework\Data\Form\FormKey   $formKey
     * @param    \Magento\Framework\Registry            $coreRegistry
     * @param    \Webkul\FormBuilder\Model\FormFactory  $FormFactory
     * @param    \Webkul\FormBuilder\Helper\Data        $helper
     * @param    array                                  $data = []
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\Registry $coreRegistry,
        \Webkul\FormBuilder\Model\FormFactory $FormFactory,
        \Webkul\LeadToQuote\Api\Data\IndustryBusinessMappingInterfaceFactory $indbusmapFact,
        \Webkul\LeadToQuote\Model\Config\Source\IndustryType $industryOptions,
        \Webkul\LeadToQuote\Model\Config\Source\BusinessType $businessOptions,
        \Webkul\FormBuilder\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->indbusmapFact = $indbusmapFact;
        $this->industryOptions = $industryOptions;
        $this->businessOptions = $businessOptions;
        $this->formKey = $formKey;
        $this->formFactory = $FormFactory;
        $this->coreRegistry = $coreRegistry;
        $this->helper= $helper;
    }

    /**
     * Get Form Key
     *
     * @return string
     */
    public function getFormKey()
    {
         return $this->formKey->getFormKey();
    }

    /**
     * Get Form Details By ID (CoreRegistry)
     *
     * @return string
     */
    public function getFormInfoById()
    {
        $id = $this->coreRegistry->registry('formDataId');
        $form = $this->formFactory->create();
        $result = $form->load($id);
        $result = $result->getData();
        $formFields = isset($result["forms_fields"]) ? json_decode($result["forms_fields"], true) : [];
        $result["forms_fields"] = json_encode(array_filter($formFields));
        return $result;
    }

    /**
     * Get locale code
     *
     * @return string
     */
    public function getLocale()
    {
        return str_replace('_', '-', $this->helper->getLocale());
    }

    /**
     * Get Field Data function
     *
     * @param string $field
     * @return void
     */
    public function getFieldData($field = "", $block)
    {
        $fieldData = [];
        switch ($field) {
            case "prefix":
                $fieldData["name"] = $block->getFieldName('prefix');
                $fieldData["placeholder"] = "";
                $fieldData["required"] = $block->isPrefixRequired();
                $fieldData["label"] = $block->getStoreLabel('prefix');
                $fieldData["subtype"] = "text";
                $fieldData["type"] = "text";
                $fieldData["className"] = "input-text ".$block->getAttributeValidationClass('prefix');
                break;
            case "firstname":
                $fieldData["name"] = $block->getFieldName('firstname');
                $fieldData["placeholder"] = "";
                $fieldData["required"] = true;
                $fieldData["label"] = $block->getStoreLabel('firstname');
                $fieldData["subtype"] = "text";
                $fieldData["type"] = "text";
                $fieldData["className"] = "input-text ".$block->getAttributeValidationClass('firstname');
                break;
            case "middlename":
                $fieldData["name"] = $block->getFieldName('middlename');
                $fieldData["placeholder"] = "";
                $fieldData["required"] = $block->isMiddlenameRequired();
                $fieldData["label"] = $block->getStoreLabel('middlename');
                $fieldData["subtype"] = "text";
                $fieldData["type"] = "text";
                $fieldData["className"] = "input-text ".$block->getAttributeValidationClass('middlename');
                break;
            case "lastname":
                $fieldData["name"] = $block->getFieldName('lastname');
                $fieldData["placeholder"] = "";
                $fieldData["required"] = true;
                $fieldData["label"] = $block->getStoreLabel('lastname');
                $fieldData["subtype"] = "text";
                $fieldData["type"] = "text";
                $fieldData["className"] = "input-text ".$block->getAttributeValidationClass('lastname');
                break;
            case "suffix":
                $fieldData["name"] = $block->getFieldName('suffix');
                $fieldData["placeholder"] = "";
                $fieldData["required"] = $block->isSuffixRequired();
                $fieldData["label"] = $block->getStoreLabel('suffix');
                $fieldData["subtype"] = "text";
                $fieldData["type"] = "text";
                $fieldData["className"] = "input-text ".$block->getAttributeValidationClass('suffix');
                break;
            case "newsletter":
                return [
                    'name' => "is_subscribed",
                    'id' => "is_subscribed",
                    'className' => "checkbox",
                    'values' => 1,
                    'type' => "checkbox",
                    'required' => false,
                    'values' => [[
                        'label' => __('Sign Up for Newsletter'),
                        'value' => 1
                    ]]
                ];
            break;
            case "dob":
                return [
                    'extra_params' => $block->getHtmlExtraParams(),
                    'name' => $block->getHtmlId(),
                    'id' => $block->getHtmlId(),
                    'className' => "input-text ".$block->getHtmlClass(),
                    'date_format' => $block->getDateFormat(),
                    'image' => $block->getViewFileUrl('Magento_Theme::calendar.png'),
                    'years_range' => '-120y:c+nn',
                    'max_date' => '-1d',
                    'change_month' => 'true',
                    'change_year' => 'true',
                    'type' => 'date',
                    'show_on' => 'both',
                    'first_day' => $block->getFirstDay(),
                    'required' => $block->isRequired(),
                    'label' => $block->getStoreLabel('dob')
                ];
            break;
            case "taxvat":
                return [
                    'name' => $block->getFieldName('taxvat'),
                    'id' => $block->getFieldId('taxvat'),
                    'className' => "input-text",
                    'value' => $block->getValue(),
                    'type' => "text",
                    'subtype' => "text",
                    'required' => $block->isRequired(),
                    'label' => $block->getStoreLabel('taxvat')
                ];
            break;
            case "gender":
                return [
                    'name' => $block->getFieldName('gender'),
                    'id' => $block->getFieldId('gender'),
                    'className' => "validate-select",
                    'type' => "select",
                    'values' => $this->getOptions($block->getGenderOptions()),
                    'required' => $block->isRequired(),
                    'label' => $block->getStoreLabel('gender')
                ];
            break;
            case "email":
                return [
                    'name' => "email",
                    'id' => "email_address",
                    'className' => "input-text",
                    'type' => "text",
                    'subtype' => 'email',
                    'required' => "true",
                    'autocomplete' => "email",
                    'label' => __('Email')
                ];
            break;
            case "password":
                return [
                    'name' => "password",
                    'id' => "password",
                    'className' => "input-text",
                    'type' => "text",
                    'subtype' => 'password',
                    'required' => "true",
                    'autocomplete' => "off",
                    'label' => __('Password')
                ];
            break;
            case "password_confirmation":
                return [
                    'name' => "password_confirmation",
                    'id' => "password-confirmation",
                    'className' => "input-text",
                    'type' => "text",
                    'subtype' => 'password',
                    'required' => "true",
                    'autocomplete' => "off",
                    'label' => __('Confirm Password')
                ];
            break;
        }
        return $fieldData;
    }

    public function getIndustryBusinessData()
    {
        $industryOptions = $this->industryOptions->toOptionArray();
        $businessOptions = $this->businessOptions->toOptionArray();
        $allData = [];
        foreach ($industryOptions as $industryOption) {
            $businessData = [];
            $industryData = $industryOption;
            $industryBusinessMappingColl = $this->indbusmapFact->create()->getCollection()
                                                ->addFieldToFilter("industry_option_id", $industryOption["value"]);
            foreach ($industryBusinessMappingColl as $industryBusinessMappingItem) {
                if (isset($businessOptions[$industryBusinessMappingItem->getBusinessOptionId()])) {
                    $businessData[] = $businessOptions[$industryBusinessMappingItem->getBusinessOptionId()];
                }
            }

            if (count($businessData) > 0) {
                $industryData["renderType"] = 1;
                $industryData["name"] = "business_type";
                $industryData["values"] = $businessData;
                $industryData["type"] = "radio-group";
                $allData[] = $industryData;
            }
        }
        return $allData;
    }


    /**
     * Get options function
     *
     * @param array $options
     * @return void
     */
    public function getOptions($options)
    {
        $optionsArr = [];
        foreach ($options as $option) {
            $optionsArr[] = $option->__toArray();
        }

        return $optionsArr;
    }
}
