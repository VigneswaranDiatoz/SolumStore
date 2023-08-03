<?php

namespace Webkul\FormBuilder\Setup\Patch\Data;

use Magento\Framework\Setup;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InstallDefaultData implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    /**
     * @var Setup\SampleData\Executor
     */
    protected $executor;

    /**
     * @param Setup\SampleData\Executor $executor
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Webkul\SolumeslTheme\Model\Block $block
     */
    public function __construct(
        Setup\SampleData\Executor $executor,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->executor = $executor;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->generalSettingData($this->moduleDataSetup);
    }

    /**
     * General settings
     *
     * @param ModuleDataSetupInterface $setup
     * @return void
     */
    public function generalSettingData($setup)
    {
        $setup->startSetup();
        $tableName = $setup->getTable("wk_form");
        if ($setup->getConnection()->isTableExists($tableName) == true) {
            $tabledata = [
                [
                    'entity_id' => 1,
                    'name' => 'rfq-form',
                    'url_key' => "rfq-form",
                    'success_url' => null,
                    'step1_label' => __("Join to Solum Store"),
                    'login_label' => __("Sign In to Solum Store"),
                    'create_label' => __("Join Solum Store"),
                    'status' => 1,
                    'forms_fields' => '[{"stepName":"Which Solution are you interested in?","data":"[\n  {\n    \"type\": \"category\",\n    \"required\": false,\n    \"name\": \"type\",\n    \"value\": \"34,35,36\",\n    \"seller\": \"0\"\n  }\n]"},{"stepName":"Please let us know more about your business","data":"[\n  {\n    \"type\": \"radio-group\",\n    \"required\": false,\n    \"label\": \"Food Retail\",\n    \"name\": \"business_type\",\n    \"renderType\": \"1\",\n    \"openAccord\": \"0\",\n    \"values\": [\n      {\n        \"label\": \"Food Retail\",\n        \"value\": \"Food Retail\",\n        \"selected\": false\n      }\n    ]\n  },\n  {\n    \"type\": \"radio-group\",\n    \"required\": false,\n    \"label\": \"Home\",\n    \"name\": \"business_type\",\n    \"renderType\": \"1\",\n    \"openAccord\": \"1\",\n    \"values\": [\n      {\n        \"label\": \"Cafe And Bakery\",\n        \"value\": \"Cafe And Bakery\",\n        \"selected\": false\n      },\n      {\n        \"label\": \"Convenience Store\",\n        \"value\": \"Convenience Store\",\n        \"selected\": false\n      },\n      {\n        \"label\": \"Grocery/Supermarket\",\n        \"value\": \"Grocery/Supermarket\",\n        \"selected\": false\n      },\n      {\n        \"label\": \"Hypermarket\",\n        \"value\": \"Hypermarket\",\n        \"selected\": false\n      },\n      {\n        \"label\": \"City/Express Store\",\n        \"value\": \"City/Express Store\",\n        \"selected\": false\n      }\n    ]\n  }\n]"},{"stepName":"Please let us know more about your business","data":"[\n  {\n    \"type\": \"number\",\n    \"required\": false,\n    \"placeholder\": \"Number of Stores\",\n    \"name\": \"no_of_stores\"\n  },\n  {\n    \"type\": \"number\",\n    \"required\": false,\n    \"placeholder\": \"Quantity per Store\",\n    \"className\": \"form-control\",\n    \"name\": \"no_of_label\"\n  }\n]"},{"stepName":"Leave your business requirement in detail","data":"[\n  {\n    \"type\": \"textarea\",\n    \"required\": false,\n    \"placeholder\": \"Message\",\n    \"className\": \"form-control\",\n    \"name\": \"message\",\n    \"subtype\": \"textarea\",\n    \"rows\": 8\n  },\n  {\n    \"type\": \"file\",\n    \"required\": false,\n    \"className\": \"form-control\",\n    \"name\": \"file\",\n    \"subtype\": \"file\",\n    \"multiple\": true\n  }\n]"}]',
                    'submit_button' => null,
                    'success_message' => 'Thank you for submitting!, our sales team will get back to you soon.',
                    'recaptcha' => 0,
                ],
            ];
            foreach ($tabledata as $data) {
                $setup->getConnection()->insert($tableName, $data);
            }
        }
        $setup->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }
}
