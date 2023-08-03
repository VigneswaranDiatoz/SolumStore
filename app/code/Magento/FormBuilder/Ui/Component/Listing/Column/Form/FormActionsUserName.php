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

class FormActionsUserName extends Column
{
    /**
     * @var string
     */
    protected $urlBuilder;
    
    /**
     * @var string
     */
    private $editUrl;

    /**
     * @param ContextInterface      $context
     * @param UiComponentFactory    $uiComponentFactory
     * @param UrlInterface          $urlBuilder
     * @param Data                  $Data
     * @param array                 $components
     * @param array                 $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Data  $Data,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->helper  = $Data;
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
                        'href' =>
                            $this->urlBuilder->getUrl(
                                'customer/index/edit',
                                ['id' => $item['user_id'],
                                'seller_panel' => 1]
                            ),
                        'label' => __($this->userName($item['user_id']))
                    ];
                }
            }
        }
        return $dataSource;
    }

    /**
     * Get User Name
     *
     * @param int $id
     * @return string
     */
    public function userName($id)
    {
        $username  = $this->helper->getUserNameById($id);
        return !empty($username && $id) ?  $username : __('Guest');
    }
}
