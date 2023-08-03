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
namespace Webkul\FormBuilder\Ui\Component\Listing\Column\Form;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Webkul\FormBuilder\Helper\Data;

class FormActionsViewResponse extends Column
{
    /** Url path */
    public const URL = 'formbuilder/response/index';
    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $Helper
     * @param string $editUrl
     * @param array $data = []
     * @param array $components
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Data  $Helper,
        $editUrl = self::URL,
        array $data = [],
        array $components = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        $this->helper  = $Helper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
      
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                
                if (isset($item['entity_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(
                            "formbuilder/response/index",
                            ['form_id' => $item['entity_id']]
                        ),
                        'label' => __('View (%1)', $this->totalResponse($item['entity_id']))
                    ];
                }
            }
        }
        return $dataSource;
    }

    /**
     * Get Total Response
     *
     * @param int $id
     * @return int
     */
    public function totalResponse($id)
    {
        return $this->helper->getTotalResponseById($id);
    }
}
