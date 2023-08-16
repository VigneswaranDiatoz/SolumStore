<?php
namespace Magento\AdminRFQ\Block\Adminhtml\Grid\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) 
    {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form', 
                            'enctype' => 'multipart/form-data', 
                            'action' => $this->getData('action'), 
                            'method' => 'post'
                        ]
            ]
        );

        $form->setHtmlIdPrefix('smb_');
        if ($model->getEntityId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Article Data'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Article Data'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'customer_id',
            'text',
            [
                'name' => 'customer_id',
                'label' => __('Customer Name'),
                'id' => 'customer_id',
                'title' => __('Customer Name'),
                'class' => 'required-entry',
                'disabled'=>'diabled',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'partner_id',
            'text',
            [
                'name' => 'Partner_id',
                'label' => __('SI Partner Name'),
                'id' => 'business_name',
                'title' => __('SI Partner Name'),
                'class' => 'required-entry',
                'disabled'=>'diabled',
                'required' => true,
            ]
            );

        $fieldset->addField(
            'product_id',
            'text',
            [
                'name' => 'product_id',
                'label' => __('Product Name'),
                'id' => 'product_id',
                'title' => __('Product Name'),
                'class' => 'required-entry',
                'disabled'=>'diabled',
                'required' => true,
            ]
            );
        $fieldset->addField(
            'status',
            'text',
            [
                'name' => 'status',
                'label' => __('Status'),
                'id' => 'status',
                'title' => __('Status'),
                'class' => 'required-entry',
                'required' => true,
            ]
            );
            $fieldset->addField(
                'no_of_stores',
                'text',
                [
                    'name' => 'no_of_stores',
                    'label' => __('No Of Stores'),
                    'id' => 'no_of_stores',
                    'title' => __('No Of Stores'),
                    'class' => 'required-entry',
                    'required' => true,
                ]
                );
            $fieldset->addField(
                'quantity_per_store',
                'text',
                [
                    'name' => 'quantity_per_store',
                    'label' => __('Quantity Per Store'),
                    'id' => 'quantity_per_store',
                    'title' => __('Quantity Per Store'),
                    'class' => 'required-entry',
                    'required' => true,
                ]
                );
            $fieldset->addField(
                'comment',
                'text',
                [
                    'name' => 'comment',
                    'label' => __('Message'),
                    'id' => 'comment',
                    'title' => __('Message'),
                    'class' => 'required-entry',
                    'required' => true,
                ]
                );

        // $fieldset->addField(
        //     'solum_partner',
        //     'text',
        //     [
        //         'name' => 'solum_partner',
        //         'label' => __('Solum Partner'),
        //         'id' => 'solum_partner',
        //         'title' => __('Solum Partner'),
        //         'class' => 'required-entry',
        //         'required' => true,
        //     ]
        //     );

        
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}