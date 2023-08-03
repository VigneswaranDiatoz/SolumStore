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

class FormActions extends Column
{
    /** Url path */
    public const EDIT = 'formbuilder/forms/edit';
    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * @param UiComponentFactory    $uiComponentFactory
     * @param ContextInterface      $context
     * @param UrlInterface          $urlBuilder
     * @param string                $editUrl
     * @param array                 $components
     * @param array                 $data
     */
    public function __construct(
        UiComponentFactory $uiComponentFactory,
        ContextInterface $context,
        UrlInterface $urlBuilder,
        $editUrl = self::EDIT,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
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
                            $this->editUrl,
                            ['entity_id' => $item['entity_id']]
                        ),
                        'label' => __('Edit ')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
