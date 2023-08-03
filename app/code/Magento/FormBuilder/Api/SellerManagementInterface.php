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

namespace Webkul\FormBuilder\Api;

interface SellerManagementInterface
{
    /**
     * Return the all seller category
     *
     * @param int $rootCategoryId
     * @param int $depth
     * @param boolean $isChildrenNeeded
     * @throws \Magento\Framework\Exception\NoSuchEntityException If ID is not found
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getSellerSubCategory($rootCategoryId = null, $depth = null, $isChildrenNeeded = true);

    /**
     * Get the phone code for a particular country
     *
     * @param string $code
     *
     * @return int
     */
    public function getPhoneCode($code);
}
