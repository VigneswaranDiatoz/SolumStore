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

namespace Webkul\FormBuilder\Model;

class SellerManagement implements \Webkul\FormBuilder\Api\SellerManagementInterface
{

    protected $allSubCategories = [];
    public function __construct(
        \Magento\Catalog\Api\CategoryManagementInterface $catManage,
        \Webkul\FormBuilder\Helper\Data $helper,
        \Webkul\Marketplace\Model\SellerFactory $sellerFactory
    ) {
        $this->catManage = $catManage;
        $this->helper = $helper;
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * @inheritDoc
     */
    public function getSellerSubCategory($rootCategoryId = null, $depth = null, $isChildrenNeeded = true)
    {
        $category = $this->catManage->getTree($rootCategoryId, $depth);
        $this->allSubCategories = [];
        $this->getAllSubcategories($category, $isChildrenNeeded);
        return $this->allSubCategories;
    }

    public function getAllSubcategories($cat, $isChildrenNeeded)
    {
        $children = $cat->getChildrenData();
        if ($isChildrenNeeded) {
            foreach ($children as $child) {
                $this->getAllSubcategories($child, $isChildrenNeeded);
            }
        }
        $catId = $cat->getId();
        $sellers = $this->sellerFactory->create()->getCollection()
                            ->addFieldToSelect("seller_id")
                            ->addFieldToSelect("shop_url")
                            ->addFieldToSelect("shop_title")
                            ->addFieldToFilter("allowed_categories", ["finset" => $catId]);
        if ($sellers->getSize()) {
            $subcat["name"] = $cat->getName();
            $subcat["id"] = $catId;
            $subcat["sellers"] = $sellers->getData();
            $this->allSubCategories[] = $subcat;
        }
    }

    public function getPhoneCode($code)
    {
        return $this->helper->getPhoneCode($code);
    }
}
