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

namespace Webkul\FormBuilder\Controller\Wysiwyg\Gallery;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;
use Webkul\FormBuilder\Api\Data\WysiwygImageInterfaceFactory;
use Webkul\FormBuilder\Helper\Data as FbHelper;
use Magento\Framework\Exception\LocalizedException;

/**
 * FormBuilder Wysiwyg Image Upload controller.
 */
class Upload extends Action
{
    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $fileUploaderFactory;
    
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    
    /**
     * @var WysiwygImageInterfaceFactory
     */
    protected $wysiwygImage;
    
    /**
     * @var FbHelper
     */
    protected $FbHelper;
    
    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * @var \Webkul\ImageUploader\Helper\Data
     */
    protected $imageUploaderHelper;

    /**
     * __construct
     *
     * @param \Magento\Framework\App\Action\Context             $context
     * @param Filesystem                                        $filesystem,
     * @param \Magento\MediaStorage\Model\File\UploaderFactory  $fileUploaderFactory,
     * @param StoreManagerInterface                             $storeManager
     * @param WysiwygImageInterfaceFactory                      $wysiwygImage
     * @param FbHelper                                          $FbHelper
     * @param \Magento\Framework\Json\Helper\Data               $jsonHelper
     */
    public function __construct(
        Context $context,
        Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem\Io\File $file,
        \Magento\Framework\View\Asset\Repository $assetRepo,
        WysiwygImageInterfaceFactory $wysiwygImage,
        FbHelper $FbHelper,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Webkul\ImageUploader\Helper\Data $imageUploaderHelper
    ) {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(
            DirectoryList::MEDIA
        );
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->storeManager = $storeManager;
        $this->wysiwygImage = $wysiwygImage;
        $this->file = $file;
        $this->FbHelper = $FbHelper;
        $this->_assetRepo = $assetRepo;
        $this->jsonHelper = $jsonHelper;
        $this->imageUploaderHelper = $imageUploaderHelper;
        parent::__construct($context);
    }

    /**
     * Function execute
     */
    public function execute()
    {
        $helper = $this->FbHelper;
        $userId = $helper->getCustomer();
        try {
            $target = $this->mediaDirectory->getAbsolutePath(
                'webkul/form'
            );
            $fileUploader = $this->fileUploaderFactory->create(
                ['fileId' => 'image']
            );
            $maxSize = $helper->getConfigValue('solumesl_theme/formbuilder_leadform/attachment_filesize');
            if ($maxSize > 0 && $fileUploader->getFileSize()/(1000000) > $maxSize) {
                throw new LocalizedException(
                    __('The file you\'re uploading exceeds the max size limit of %1 MB.', $maxSize)
                );
            }
            $fileUploader->setAllowedExtensions(
                ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx']
            );
            $fileUploader->setFilesDispersion(true);
            $fileUploader->setAllowRenameFiles(true);
            $resultData = $fileUploader->save($target);
            unset($resultData['tmp_name']);
            unset($resultData['path']);
            $resultData['url'] = $this->storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'webkul/form' . '/' . ltrim(str_replace('\\', '/', $resultData['file']), '/');
            $resultData['view_url'] = $resultData['url'];
            $resultData['file'] = $resultData['file'];
            $fileExt = $this->file->getPathInfo($resultData['name'])["extension"];
            $imageUrl = $this->imageUploaderHelper->getDisplayImageUrl($fileExt);

            if ($imageUrl) {
                $resultData['url'] = $this->getViewFileUrl($imageUrl);
            }

            $checkVal = $this->saveImageDesc($userId, $resultData['url'], $resultData['file'] . '.tmp');
            
            $this->getResponse()->representJson(
                $this->jsonHelper->jsonEncode($resultData)
            );
        } catch (\Exception $e) {
            
            $this->getResponse()->representJson(
                $this->jsonHelper->jsonEncode(
                    [
                        'error' => $e->getMessage(),
                        'errorcode' => $e->getCode(),
                    ]
                )
            );
        }
    }
    /**
     * SaveImageDesc function
     *
     * @param int $userId
     * @param string $imageUrl
     * @param string $imageName
     * @return bool
     */
    public function saveImageDesc($userId, $imageUrl, $imageName)
    {
        try {
            $imageinfo = getimagesizefromstring($imageUrl);
            $file = explode("desc", $imageUrl);
            $nameArray = explode("/", $imageName);
            $name = explode(".tmp", $nameArray[count($nameArray)-1])[0];
            $descImage = $this->wysiwygImage->create();
            $descImage->setUserId($userId);
            $descImage->setUrl($imageUrl);
            $descImage->setName($name);
            $descImage->setFile($file[1]);
            $descImage->setType($imageinfo["mime"]);
            $descImage->save();
            return 1;
        } catch (\Exception $e) {
            
            return 0;
        }
    }

    /**
     * Retrieve url of a view file
     *
     * @param string $fileId
     * @param array $params
     * @return string
     */
    public function getViewFileUrl($fileId, array $params = [])
    {
        try {
            $params = array_merge(['_secure' => $this->getRequest()->isSecure()], $params);
            return $this->_assetRepo->getUrlWithParams($fileId, $params);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return "";
        }
    }
}
