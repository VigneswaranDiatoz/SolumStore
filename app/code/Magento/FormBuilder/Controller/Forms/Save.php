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

namespace Webkul\FormBuilder\Controller\Forms;

use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Webkul\LeadToQuote\Model\Leads\Generate\Publisher;
use Webkul\LeadToQuote\Api\Data\LeadsInterface;

class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var context
     */
    protected $context;
    /**
     * @var $resultPageFactory
     */
    protected $_resultPageFactory;
    /**
     * @var $formKeyValidator
     */
    protected $formKeyValidator;
    /**
     * @var $formBuilder
     */
    protected $formBuilder;
    /**
     * @var $responseBuilder
     */
    protected $responseBuilder;

    /**
     * @var $helper
     */
    protected $helper;

    /**
     * @var $successUrl
     */
    protected $successUrl;

    /**
     * @param    \Magento\Backend\Block\Widget\Context                  $context
     * @param    \Magento\Framework\Stdlib\DateTime\DateTime            $date
     * @param    \Magento\Framework\View\Result\PageFactory             $resultPageFactory
     * @param    \Magento\Framework\Data\Form\FormKey\Validator         $formKeyValidator
     * @param    \Webkul\FormBuilder\Model\FormFactory                  $formBuilder
     * @param    \Webkul\FormBuilder\Model\ResponseFactory              $responseBuilder
     * @param    \Webkul\FormBuilder\Helper\Data                        $data
     * @param    Filesystem                                             $filesystem
     * @param    UploaderFactory                                        $fileUploader
     * @param    \Magento\Framework\Filesystem\Io\File                  $file
     * @param    \Magento\Framework\Controller\Result\RedirectFactory   $resultRedirectFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Webkul\FormBuilder\Model\FormFactory $formBuilder,
        \Webkul\FormBuilder\Model\ResponseFactory $responseBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Webkul\FormBuilder\Helper\Data $data,
        Filesystem $filesystem,
        UploaderFactory $fileUploader,
        Publisher $publisher,
        \Magento\Framework\Filesystem\Io\File $file,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->formKeyValidator = $formKeyValidator;
        $this->formBuilder = $formBuilder;
        $this->responseBuilder  = $responseBuilder;
        $this->_date = $date;
        $this->helper  = $data;
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        $this->fileUploader = $fileUploader;
        $this->publisher = $publisher;
        $this->file = $file;
        $this->layoutFactory = $layoutFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->resultRedirectFactory  = $resultRedirectFactory;
    }

    /**
     * Function execute
     */
    public function execute()
    {
        $resultData = [
            "error" => true,
            "message" => __('Something went wrong.')
        ];
        $data = $this->getRequest()->getPostValue();
        $datafile = '';
        $token = $data['g-recaptcha-response'];
        $recaptcha = $data['recaptcha'];

        $this->successUrl = isset($data) && !empty($data['success_url']) ? $data['success_url'] : '';

        if ($this->helper->enableRecaptcha() && $this->helper->checkRecaptcha($recaptcha)) {
            if (!$this->helper->validateRecaptcha($token)) {
                $this->messageManager->addError(__('Invalid Form'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath($this->successUrl);
                return $resultRedirect;
            }
        }

        // Checked the date
        // if (isset($data['res'])) {
        //     foreach ($data['res'] as $key => $label) {
        //         if (str_contains($key, "date-") && !empty($label['value'])) {
        //             $isVaild = (bool) strtotime($label['value']);
        //             if (!$isVaild) {
        //                 $this->messageManager->addError(__('Invalid Date'));
        //                 $resultRedirect = $this->resultRedirectFactory->create();
        //                 $resultRedirect->setPath($this->successUrl);
        //                 return $resultRedirect;
        //             }
        //         }
        //     }
        // }
        $leadData = $data['res'];
        $caseStudyHtml = "";

        $data['response'] = $this->helper->jsonEncode($data['res']);

        $responseModel = $this->responseBuilder->create();
        $responseModel->setFormId($data['formId']);
        $responseModel->setUserIp($this->helper->getCustomerIp());
        $responseModel->setUserId($this->helper->getCustomer());
        $responseModel->setStoreId($this->helper->getStoreId());
        $responseModel->setCreatedAt($this->_date->gmtDate());
        $responseModel->setUpdatedAt($this->_date->gmtDate());
        $responseModel->setFormsResponse($data['response']);
        $responseModel->save();
        try {
            $noOfStore = (isset($leadData["no_of_stores"]["value"]) && $leadData["no_of_stores"]["value"] != "") ? $leadData["no_of_stores"]["value"] : 0;
            $noOfLabel = (isset($leadData["no_of_label"]["value"]) && $leadData["no_of_label"]["value"] != "") ? $leadData["no_of_label"]["value"] : 0;
            $additionalData = [];
            foreach ($data['res'] as $key => $value) {
                if (!in_array($key, ["type", "customer_id", "seller_id", "subject", "qty", "store_id", "no_of_stores", "sample_images", "type", "message", "business_type", "source_page", "status"]) && isset($value["value"])) {
                    if (isset($value["label"])) {
                        $additionalData[$value["label"]] = $value["value"];
                    } else {
                        $additionalData[] = $value["value"];
                    }
                }
            }
            $publishData = [
                // "type" => $leadData["type"]["value"] ?? $this->storeManager->getStore()->getRootCategoryId(),
                "type" => $leadData["type"]["value"] ?? 0,
                "store_id" => $this->storeManager->getStore()->getId(),
                "customer_id" => $this->helper->getCustomer(),
                "seller_id" => [],
                "message" => $leadData["message"]["value"] ?? "",
                "subject" => $leadData["subject"]["value"] ?? "",
                "sample_images" => $leadData["sample_images"]["value"] ?? [],
                "source_page" => $leadData["source_page"]["value"] ?? [],
                "business_type" => $leadData["business_type"]["value"] ?? [],
                "no_of_stores" => $noOfStore,
                "status" => LeadsInterface::STATUS_OPEN,
                "qty" => ($noOfLabel),
                "additional_data" => $additionalData,
            ];
            if ($publishData["message"] != "" && $publishData["subject"] == "") {
                $publishData["subject"] = substr($publishData["message"], 0, 10);
            }
            $caseStudyHtml = $this->layoutFactory->create()->createBlock(\Webkul\FormBuilder\Block\Casestudy\Listing::class)->toHtml();
            $this->publisher->publish($publishData);
        } catch (\Exception $e) {
        }
        $resultData = [
            "error" => false,
            "message" => __("Successfully created."),
            "caseStudyHtml" => $caseStudyHtml
        ];
        $this->getResponse()->representJson(
            $this->helper->jsonEncode($resultData)
        );
    }

    /**
     * Add the userData arrya in the file type response
     *
     * @param array $data
     * @param array $uploadedFileName
     * @return array jsonEncode response
     */
    public function appendFileData($data, $uploadedFileName)
    {
        if (isset($uploadedFileName) && !empty($uploadedFileName && isset($data))) {
            $respones = ($data);
            $respones['wk_file']['value'] = $uploadedFileName;
            return ($respones);
        }
    }

    /**
     * Here main function to upload the media
     *
     * @param string $inputFileName
     * @return array uploadedFiles
     */
    public function uploadFile($inputFileName)
    {

        $folder = 'FormBuilder/Media';
        try {
            $file = $inputFileName;
            $fileName = ($file && array_key_exists('name', $file)) ? $file['name'] : null;

            if ($file && $fileName) {
                $target = $this->mediaDirectory->getAbsolutePath($folder);

                /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
                $uploader = $this->fileUploader->create(['fileId' => $inputFileName]);

                // set allowed file extensions
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'pdf', 'doc', 'png']);

                // allow folder creation
                $uploader->setAllowCreateFolders(true);

                // rename file name if already exists
                $uploader->setAllowRenameFiles(true);

                // upload file in the specified folder
                $result = $uploader->save($target);

                if ($result['file']) {
                    $this->messageManager->addSuccess(__('File has been successfully uploaded'));
                }
                return $uploader->getUploadedFileName();
            }
        } catch (\Exception $e) {
            $ext = $this->file->getPathInfo($fileName, PATHINFO_EXTENSION);
            $message = __(' "%1" File Type Not Allowed or image size exceeds .', $ext['extension']);
            $this->messageManager->addError($message);
            return false;
        }
        return false;
    }
}
