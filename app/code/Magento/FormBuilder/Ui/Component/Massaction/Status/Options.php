<?php
/**
 * Webkul Software
 *
 * @category Webkul
 * @package Webkul_FormBuilder
 * @author Webkul
 * @copyright Copyright (c)  Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */

namespace Webkul\FormBuilder\Ui\Component\MassAction\Status;

use Magento\Framework\UrlInterface;
use Zend\Stdlib\JsonSerializable;

/**
 * Class Options
 * Return the Sub dropdown
 *
 */
class Options implements JsonSerializable
{
    /**
     * @var array
     */
    protected $_options;

    /**
     * @var array
     */
    protected $_data;

    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;

    /**
     * @var string
     */
    protected $_urlPath;

    /**
     * @var string
     */
    protected $_paramName;

    /**
     * @var array
     */
    protected $_additionalData = [];

    /**
     * Constructor
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->_data = $data;
        $this->_urlBuilder = $urlBuilder;
    }

    /**
     * Get action options
     *
     * @return array
     */
    public function jsonSerialize()
    {
         
        if ($this->_options === null) {
            //make a array of massaction
            $options[0]['value']=0;
            $options[0]['label']='Disable';
            $options[1]['value']=1;
            $options[1]['label']='Enable';
            $this->prepareData();
            
            // $this->_options = array_values($this->_options);
        }
        return $this->_options;
    }

    /**
     * Prepare addition data for subactions
     *
     * @return void
     */
    protected function prepareData()
    {
        foreach ($this->_data as $key => $value) {
            switch ($key) {
                case 'urlPath':
                    $this->_urlPath = $value;
                    break;
                case 'paramName':
                    $this->_paramName = $value;
                    break;
                default:
                    $this->_additionalData[$key] = $value;
                    break;
            }
        }
    }
}
