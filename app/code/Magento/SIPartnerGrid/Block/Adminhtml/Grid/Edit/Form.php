<?php
namespace Magento\SIPartnerGrid\Block\Adminhtml\Grid\Edit;

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
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Email'),
                'id' => 'email',
                'title' => __('Email'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'business_name',
            'text',
            [
                'name' => 'business_name',
                'label' => __('Business Name'),
                'id' => 'business_name',
                'title' => __('Business Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
            );

        $fieldset->addField(
            'address',
            'text',
            [
                'name' => 'address',
                'label' => __('Address'),
                'id' => 'address',
                'title' => __('Address'),
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

        $fieldset->addField(
            'sales_size',
            'text',
            [
                'name' => 'sales_size',
                'label' => __('Sales Size'),
                'id' => 'sales_size',
                'title' => __('Sales Size'),
                'class' => 'required-entry',
                'required' => true,
            ]
            );

        $fieldset->addField(
            'credit_ratings',
            'text',
            [
                'name' => 'credit_ratings',
                'label' => __('Credit Ratings'),
                'id' => 'credit_ratings',
                'title' => __('Credit Ratings'),
                'class' => 'required-entry',
                'required' => true,
            ]
            );
        
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}