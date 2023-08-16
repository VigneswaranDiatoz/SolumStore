<?php

namespace Magento\AdminRFQ\Ui\Component\Listing\Grid\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Action extends Column
{
    /** Url path */
    const ROW_EDIT_URL = 'adminrfq/grid/addrow/';
    const ROW_STATUS_URL = 'adminrfq/grid/changestatus/';
    /** @var UrlInterface */
    protected $_urlBuilder;

    /**
     * @var string
     */
    private $_editUrl;
    private $_statusUrl;
    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     * @param string             $editUrl
     * @param string             $statusUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::ROW_EDIT_URL,
        $statusUrl=self::ROW_STATUS_URL    
        
    ) 
    {
        $this->_urlBuilder = $urlBuilder;
        $this->_editUrl = $editUrl;
        $this->_statusUrl=$statusUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $data=$dataSource['data'];
        if (isset($dataSource['data']['items'])) {
            $data['data']['items']=[];
            // $data["data"]=$dataSource['data'];
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                
                if (isset($item['entity_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            $this->_editUrl, 
                            ['id' => $item['entity_id']]
                        ),
                        'label' => __('Edit'),
                    ];
                    // if($item['is_active'] =='0'){
                    //     $item[$name]['delete'] = [
                    //         'href' => $this->_urlBuilder->getUrl(
                    //             $this->_statusUrl, 
                    //             ['id' => $item['entity_id'],'action'=>'accept']
                    //         ),
                    //         'label' => __('Accept'),
                    //         'confirm' => [
                    //             'title' => __('Accept'),
                    //             'message' => __('Are you sure you want to Accept the SI Partner?')
                    //         ]
                    //     ];
                    // } else if($item['is_active'] =='1'){
                    //     $item[$name]['delete'] = [
                    //         'href' => $this->_urlBuilder->getUrl(
                    //             $this->_statusUrl, 
                    //             ['id' => $item['entity_id'],'action'=>'decline']
                    //         ),
                    //         'label' => __('Decline'),
                    //         'confirm' => [
                    //             'title' => __('Decline'),
                    //             'message' => __('Are you sure you want to Decline the SI Partner?')
                    //         ]
                    //     ];
                    // }
                }
                
                // if($item['is_active'] == '3'){
                //     // $item=[];
                // } else if($item['group_id'] =='4') {
                    array_push($data["data"]["items"],$item);
                // }
            }
        }

        return $data;
    }
}