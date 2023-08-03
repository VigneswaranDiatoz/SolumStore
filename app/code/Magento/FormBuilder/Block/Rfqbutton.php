<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_formbuilder
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\FormBuilder\Block;

use Magento\Framework\UrlInterface;
use Magento\Customer\Model\SessionFactory;
use Webkul\FormBuilder\Api\Data\WysiwygImageInterfaceFactory;
use Webkul\FormBuilder\Api\Data\ResponseInterfaceFactory;

class Rfqbutton extends \Magento\Framework\View\Element\Template
{
    /**
     * Constant for product page
     */
    public const PRODUCT_PAGE = "product";

     /**
      * Constant for category page
      */
    public const CATEGORY_PAGE = "category";

    /**
     * @param \Magento\Backend\Block\Template\Context     $context
     * @param \Magento\Framework\File\Size                $fileSize
     * @param \Webkul\FormBuilder\Helper\Data             $helper
     * @param array                                       $data
     */
    public function __construct(
        SessionFactory $customerSession,
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\FormBuilder\Helper\Data $helper,
        \Magento\Catalog\Model\CategoryRepository $catRepo,
        \Magento\Framework\File\Size $fileSize,
        \Magento\Framework\Registry $registry,
        WysiwygImageInterfaceFactory $wysiwygImage,
        UrlInterface $urlInterface,
        \Magento\Customer\Model\Session $custSess,
        ResponseInterfaceFactory $wkFormResponseFact,
        \Magento\Cms\Helper\Wysiwyg\Images $wysiwygImages = null,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->urlInterface = $urlInterface;
        $this->customerSession = $customerSession;
        $this->catRepo = $catRepo;
        $this->_fileSizeService = $fileSize;
        $this->custSess = $custSess;
        $this->registry = $registry;
        $this->wysiwygImage = $wysiwygImage;
        $this->wkFormResponseFact = $wkFormResponseFact;
        $this->wysiwygImages = $wysiwygImages ?: \Magento\Framework\App\ObjectManager::getInstance()
                                  ->create(\Magento\Cms\Helper\Wysiwyg\Images::class);
        parent::__construct($context, $data);
    }

    /**
     * SaveImageDesc function
     *
     * @return \Webkul\FormBuilder\Model\WysiwygImage
     */
    public function saveImageDesc()
    {
        $userId = $this->helper->getCustomer();
        $wysiwygImage = $this->wysiwygImage->create()
                    ->getCollection()
                    ->addFieldToFilter("user_id", $userId);
        return $wysiwygImage;
    }

    public function getPreFilledData()
    {
        $userId = $this->helper->getCustomer();
        $preFilledData = $this->wkFormResponseFact->create()
                            ->getCollection()
                            ->addFieldToFilter("user_id", $userId)
                            ->getLastItem();
        return $preFilledData ? json_decode($preFilledData->getFormsResponse(), true) : [];
    }

    /**
     * Get Rfq FormFields function
     *
     * @return void
     */
    public function getRfqForm()
    {
        return $this->helper->getFormInfoById(1);
    }

    /**
     * Get Rfq FormFields function
     *
     * @return void
     */
    public function getRfqFormFieldsJson($form)
    {
        $formFields = json_decode($form["forms_fields"], true);
        $formFields = json_encode(array_filter($formFields));
        return $formFields;
    }

    /**
     * Get Rfq FormFields function
     *
     * @return void
     */
    public function getRfqFormFields($form)
    {
        $optionsTypeInput = [
            "category",
            "checkbox-group",
            "radio-group"
        ];
        $preFilledData = $this->getPreFilledData();
        $formFields = json_decode($form["forms_fields"], true);
        // $sellerStepWith = [
        //     "stepName" => __("Select seller to contact for the solution"),
        //     "data" => json_encode([[
        //         "type" => "hidden-seller-step"
        //     ]])
        // ];
        $sellerStepWithCategory = [
            "stepName" => __("Select seller to contact for the solution"),
            "data" => json_encode([[
                "type" => "hidden-seller-step",
                "showCategory" => true
            ]])
        ];
        $formFields = array_filter($formFields);
        foreach ($formFields as $key => &$fields) {
            $fieldsData = json_decode($fields["data"]);
            foreach ($fieldsData as &$field) {
                if ($field->type == "category") {
                    $field->values = $this->getCategoryData($field->value);
                }
                if ($field->name && isset($preFilledData[$field->name]) && isset($preFilledData[$field->name]["value"])) {
                    $openAccordion = false;
                    if (in_array($field->type, $optionsTypeInput)) {
                        foreach ($field->values as &$options) {
                            if ($options->value == $preFilledData[$field->name]["value"]) {
                                $options->selected = true;
                                $openAccordion = true;
                                $field->hasValue = 1;
                            }
                        }
                        if ($openAccordion) {
                            $field->openAccord = 1;
                        }
                    } else {
                        $field->value = $preFilledData[$field->name]["value"];
                        $field->hasValue = 1;
                    }
                }
                if ($field->type == "category" && $field->seller == "1") {
                    $formFields[] = $sellerStepWithCategory;
                // if( $field->type == "category") {
                //     $formFields[] = ( $field->seller == "1") ? $sellerStepWithCategory : $sellerStepWith;
                }
            }
            $fields["data"] = $fieldsData;
        }
        return $formFields;
    }

    /**
     * Get Rfq FormFields function
     *
     * @return void
     */
    public function getFirstStepName($form)
    {
        $formFields = json_decode($form["forms_fields"], true);
        return isset($formFields[1]) ? $formFields[1]["stepName"] ?? "" : "";
    }

    /**
     * Check Recaptcha Enabled
     *
     * @return Boolen
     */
    public function enableRecaptcha()
    {
        return $this->helper->enableRecaptcha();
    }
    
    /**
     * Get Site Key
     *
     * @return Boolen
     */
    public function getSiteKey()
    {
        return $this->helper->getSiteKey();
    }

    /**
     * Json Decode
     *
     * @param array $arr
     * @return array
     */
    public function jsonDecode($arr)
    {
        return $this->helper->jsonDecode($arr);
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
        if ($field && !empty($field->type) && $field->type) {
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
            
        } elseif ($field && isset($field["type"]) && $field["type"] != "") {
            switch ($field["type"]) {
                case "checkbox-group":
                    if ($type == "label") {
                        return 'res['.(!empty($field["name"]) ? $field["name"] :  $field["type"]).']['.$type.']';
                    } else {
                        return 'res['.(!empty($field["name"]) ? $field["name"] :  $field["type"]).']['.$type.'][]';
                    }
                    break;
                default:
                    return 'res['.(!empty($field["name"]) ? $field["name"] :  $field["type"]).']['.$type.']';
            }
            
        } else {
            return 'res['.$field.']['.$type.']';
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
        return $this->helper->checkRecaptcha($recaptcha);
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

    public function getCategoryData($values)
    {
        $values = explode(',', $values);
        $categoryData = [];
        foreach ($values as $categoryId) {
            try {
                $option = new \stdClass();
                $category = $this->catRepo->get($categoryId);
                $option->label = $category->getName();
                $option->value = $category->getEntityId();
                $option->selected = false;
                $categoryData[] = $option;
            } catch (\Exception $e) {

            }
        }
        return $categoryData;
    }

    public function getCustomerSession()
    {
        return $this->custSess;
    }

    /**
     * Get file size
     *
     * @return \Magento\Framework\File\Size
     */
    public function getFileSizeService()
    {
        return $this->_fileSizeService;
    }

    /**
     * Get current page info
     *
     * @return string
     */
    public function getCurrentPage()
    {
        if ($this->registry->registry("current_category")) {
            return self::CATEGORY_PAGE;
        }
        return null;
    }

    public function getDataForPage()
    {
        $currentPage = $this->getCurrentPage();
        if ($currentPage == self::CATEGORY_PAGE) {
            $currentCat = $this->registry->registry("current_category");

            $pathInStore = $currentCat->getPathInStore();
            $pathIds = array_reverse(explode(',', $pathInStore));

            $categories = $currentCat->getParentCategories();
            $parentCatId = 0;

            // add category path breadcrumb
            foreach ($pathIds as $categoryId) {
                if (isset($categories[$categoryId]) && $categories[$categoryId]->getName()) {
                    $parentCatId = $categoryId;
                    break;
                }
            }
            return [
                "selectedCatId" => $parentCatId,
            ];
        }
        return [];
    }

    public function getAttachmentFileSizeinMb()
    {
        return $this->helper->getConfigValue('solumesl_theme/formbuilder_leadform/attachment_filesize') ?? 3;
    }

    public function getAttachmentFileSize()
    {
        $valueinMB = $this->getAttachmentFileSizeinMb();
        return ($valueinMB*1024*1024);
    }
}
