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

use Webkul\FormBuilder\Api\FormBuilderInterface;

class FormBuilder implements FormBuilderInterface
{
    /**
     * @var array
     */
    protected $return = [];

     /**
      * @var collectionFactory
      */
    protected $collectionFactory;

    /**
     * @var responsecollectionFactory
     */
    protected $responsecollectionFactory;

    /**
     * @var FormFactory
     */
    protected $FormFactory;

    /**
     * @param    \Webkul\FormBuilder\Model\ResourceModel\Form\CollectionFactory $collectionFactory
     * @param    \Webkul\FormBuilder\Model\ResourceModel\Response\CollectionFactory $responsecollectionFactory
     * @param    \Webkul\FormBuilder\Model\FormFactory $formFactory
     */
    public function __construct(
        \Webkul\FormBuilder\Model\ResourceModel\Form\CollectionFactory $collectionFactory,
        \Webkul\FormBuilder\Model\ResourceModel\Response\CollectionFactory $responsecollectionFactory,
        \Webkul\FormBuilder\Model\FormFactory $formFactory
    ) {
        $this->collectionFactory  = $collectionFactory;
        $this->responsecollectionFactory  = $responsecollectionFactory;
        $this->formFactory  = $formFactory;
    }
    /**
     * Function forms
     *
     * @api
     * @return string form[]
     */
    public function forms()
    {
        $fromCollection  =  $this->collectionFactory->create();
        $data  = $fromCollection->getData();
        return $data;
    }

    /**
     * Function formById
     *
     * @api
     * @param int $id
     * @return []
     */
    public function formById($id)
    {
        $fromCollection  =  $this->collectionFactory->create();
        $fromCollection  =  $fromCollection->addFieldToFilter('entity_id', $id);
        $data  = $fromCollection->getData();
        return $data;
    }
    
    /**
     * Function response
     *
     * @api
     * @return string response[]
     */
    public function response()
    {
        $responseCollection  =  $this->responsecollectionFactory->create();
        $data  = $responseCollection->getData();
        return $data;
    }
    
    /**
     * Function responseById
     *
     * @api
     * @param int $id
     * @return []
     */
    public function responseById($id)
    {
        $responseCollection  =  $this->responsecollectionFactory->create();
        $responseCollection  =  $responseCollection->addFieldToFilter('entity_id', $id);
        $data  = $responseCollection->getData();
        return $data;
    }

    /**
     *  Add new form
     *
     * @api
     * @param string $name
     * @param string $urlKey
     * @param string $successUrl
     * @param string $status
     * @param array $forms_fields
     * @return string
     */
    public function newForm($name, $urlKey = null, $successUrl = null, $status = 1, $forms_fields = [])
    {
        
        if (!empty($name)) {
            $formModel = $this->formFactory->create();
            $formModel->setName($name);
            $formModel->setUrlKey($urlKey);
            $formModel->setStatus($status);
            $formModel->setSuccessUrl($successUrl);
            $formModel->setFormsFields($forms_fields);
            $formModel->save();
            return $this->return  = ['code'=>200,'message'=> __("Added new form=>").$formModel->getId()];
        }
        $this->return  = ['code'=>401,'message'=>"Please Enter the name"];
        return $this->return;
    }
}
