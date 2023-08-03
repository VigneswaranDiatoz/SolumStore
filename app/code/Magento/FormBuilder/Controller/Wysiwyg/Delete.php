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
namespace Webkul\FormBuilder\Controller\Wysiwyg;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Webkul\FormBuilder\Api\Data\WysiwygImageInterfaceFactory;

class Delete extends Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;
    /**
     * @var WysiwygImageInterfaceFactory
     */
    protected $wysiwygImage;

    /**
     * initialization
     *
     * @param Context                                           $context
     * @param \Magento\Framework\Controller\Result\JsonFactory  $jsonResultFactory,
     * @param WysiwygImageInterfaceFactory                      $wysiwygImage
     * @param PageFactory                                       $resultPageFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        WysiwygImageInterfaceFactory $wysiwygImage,
        PageFactory $resultPageFactory
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->wysiwygImage = $wysiwygImage;
        $this->jsonResultFactory = $jsonResultFactory;
        parent::__construct($context);
    }
    /**
     * Function execute
     */
    public function execute()
    {
        if ($this->getRequest()->isAjax()) {
            $resultJson = $this->jsonResultFactory->create();
            $params = $this->getRequest()->getParams();
            if (isset($params["imageurl"])) {
                $checkVal = $this->deleteWysiwygImages($params["imageurl"]);
                if ($checkVal) {
                    return $resultJson->setData([
                        'result' => "success",
                    ]);
                }
            }
            return $resultJson->setData([
                'result' => "failure",
            ]);
        }
    }
    /**
     * Function to deleteWysiwygImages function
     *
     * @param string $url
     * @return bool
     */
    public function deleteWysiwygImages($url)
    {
        try {
            $descImage = $this->wysiwygImage->create()->getCollection()
            ->addFieldToFilter("file", ["like"=>'%'.$url.'%']);
            $descImage->walk('delete');
            return 1;
        } catch (\Exception $e) {
            $e->getMessage();
            return 0;
        }
    }
}
