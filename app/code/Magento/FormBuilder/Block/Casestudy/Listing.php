<?php

/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_SolumeslTabs
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\FormBuilder\Block\Casestudy;

class Listing extends \Magento\Framework\View\Element\Template
{
    protected $_template = "Webkul_SolumeslTabs::widget/casestudy/listing.phtml";

    /**
     * Construct function
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Webkul\SolumeslTabs\Model\ResourceModel\CaseStudy\CollectionFactory $caseStudy
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\SolumeslTabs\Helper\Data $helperData,
        \Webkul\SolumeslTabs\Model\ResourceModel\CaseStudy\CollectionFactory $caseStudyCollection,
        array $data = []
    ) {
        $this->caseStudyCollection = $caseStudyCollection;
        $this->helperData = $helperData;
        parent::__construct($context, $data);
    }

    /**
     * Get Country by Code function
     *
     * @param string $countryCode
     * @return string
     */
    public function getCountryByCode($countryCode)
    {
        return $this->helperData->getCountryName($countryCode);
    }

    /**
     * Get Collection
     *
     * @return void
     */
    public function getCollection()
    {
        $params = $this->getRequest()->getParams();
        $pageSize = 3;
        $collection = $this->caseStudyCollection->create()
            ->addFieldToFilter('status', ['eq' => 1]);
        if (!empty($params['type'])) {
            $collection->addFieldToFilter('main_table.category_ids', ["finset" => $params['type']]);
        }
        $collection->setPageSize($pageSize);
        return $collection;
    }

    /**
     * Get trim content
     *
     * @param string $text
     * @return string
     */
    public function getTrimContent($text)
    {
        return $this->helperData->trimText($text);
    }
}
