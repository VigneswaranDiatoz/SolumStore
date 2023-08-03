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
namespace Webkul\FormBuilder\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Filesystem\DirectoryList;

class Data extends AbstractHelper
{

    /**
     * @var $formFactory
     */
    public $formFactory;

    public const COOKIE_NAME = 'customerpersistencecode';

    public const COUNTRY_CODE = [
        'AD'=>'376',
        'AE'=>'971',
        'AF'=>'93',
        'AG'=>'1268',
        'AI'=>'1264',
        'AL'=>'355',
        'AM'=>'374',
        'AN'=>'599',
        'AO'=>'244',
        'AQ'=>'672',
        'AR'=>'54',
        'AS'=>'1684',
        'AT'=>'43',
        'AU'=>'61',
        'AW'=>'297',
        'AZ'=>'994',
        'BA'=>'387',
        'BB'=>'1246',
        'BD'=>'880',
        'BE'=>'32',
        'BF'=>'226',
        'BG'=>'359',
        'BH'=>'973',
        'BI'=>'257',
        'BJ'=>'229',
        'BL'=>'590',
        'BM'=>'1441',
        'BN'=>'673',
        'BO'=>'591',
        'BR'=>'55',
        'BS'=>'1242',
        'BT'=>'975',
        'BW'=>'267',
        'BY'=>'375',
        'BZ'=>'501',
        'CA'=>'1',
        'CC'=>'61',
        'CD'=>'243',
        'CF'=>'236',
        'CG'=>'242',
        'CH'=>'41',
        'CI'=>'225',
        'CK'=>'682',
        'CL'=>'56',
        'CM'=>'237',
        'CN'=>'86',
        'CO'=>'57',
        'CR'=>'506',
        'CU'=>'53',
        'CV'=>'238',
        'CX'=>'61',
        'CY'=>'357',
        'CZ'=>'420',
        'DE'=>'49',
        'DJ'=>'253',
        'DK'=>'45',
        'DM'=>'1767',
        'DO'=>'1809',
        'DZ'=>'213',
        'EC'=>'593',
        'EE'=>'372',
        'EG'=>'20',
        'ER'=>'291',
        'ES'=>'34',
        'ET'=>'251',
        'FI'=>'358',
        'FJ'=>'679',
        'FK'=>'500',
        'FM'=>'691',
        'FO'=>'298',
        'FR'=>'33',
        'GA'=>'241',
        'GB'=>'44',
        'GD'=>'1473',
        'GE'=>'995',
        'GH'=>'233',
        'GI'=>'350',
        'GL'=>'299',
        'GM'=>'220',
        'GN'=>'224',
        'GQ'=>'240',
        'GR'=>'30',
        'GT'=>'502',
        'GU'=>'1671',
        'GW'=>'245',
        'GY'=>'592',
        'HK'=>'852',
        'HN'=>'504',
        'HR'=>'385',
        'HT'=>'509',
        'HU'=>'36',
        'ID'=>'62',
        'IE'=>'353',
        'IL'=>'972',
        'IM'=>'44',
        'IN'=>'91',
        'IQ'=>'964',
        'IR'=>'98',
        'IS'=>'354',
        'IT'=>'39',
        'JM'=>'1876',
        'JO'=>'962',
        'JP'=>'81',
        'KE'=>'254',
        'KG'=>'996',
        'KH'=>'855',
        'KI'=>'686',
        'KM'=>'269',
        'KN'=>'1869',
        'KP'=>'850',
        'KR'=>'82',
        'KW'=>'965',
        'KY'=>'1345',
        'KZ'=>'7',
        'LA'=>'856',
        'LB'=>'961',
        'LC'=>'1758',
        'LI'=>'423',
        'LK'=>'94',
        'LR'=>'231',
        'LS'=>'266',
        'LT'=>'370',
        'LU'=>'352',
        'LV'=>'371',
        'LY'=>'218',
        'MA'=>'212',
        'MC'=>'377',
        'MD'=>'373',
        'ME'=>'382',
        'MF'=>'1599',
        'MG'=>'261',
        'MH'=>'692',
        'MK'=>'389',
        'ML'=>'223',
        'MM'=>'95',
        'MN'=>'976',
        'MO'=>'853',
        'MP'=>'1670',
        'MR'=>'222',
        'MS'=>'1664',
        'MT'=>'356',
        'MU'=>'230',
        'MV'=>'960',
        'MW'=>'265',
        'MX'=>'52',
        'MY'=>'60',
        'MZ'=>'258',
        'NA'=>'264',
        'NC'=>'687',
        'NE'=>'227',
        'NG'=>'234',
        'NI'=>'505',
        'NL'=>'31',
        'NO'=>'47',
        'NP'=>'977',
        'NR'=>'674',
        'NU'=>'683',
        'NZ'=>'64',
        'OM'=>'968',
        'PA'=>'507',
        'PE'=>'51',
        'PF'=>'689',
        'PG'=>'675',
        'PH'=>'63',
        'PK'=>'92',
        'PL'=>'48',
        'PM'=>'508',
        'PN'=>'870',
        'PR'=>'1',
        'PT'=>'351',
        'PW'=>'680',
        'PY'=>'595',
        'QA'=>'974',
        'RO'=>'40',
        'RS'=>'381',
        'RU'=>'7',
        'RW'=>'250',
        'SA'=>'966',
        'SB'=>'677',
        'SC'=>'248',
        'SD'=>'249',
        'SE'=>'46',
        'SG'=>'65',
        'SH'=>'290',
        'SI'=>'386',
        'SK'=>'421',
        'SL'=>'232',
        'SM'=>'378',
        'SN'=>'221',
        'SO'=>'252',
        'SR'=>'597',
        'ST'=>'239',
        'SV'=>'503',
        'SY'=>'963',
        'SZ'=>'268',
        'TC'=>'1649',
        'TD'=>'235',
        'TG'=>'228',
        'TH'=>'66',
        'TJ'=>'992',
        'TK'=>'690',
        'TL'=>'670',
        'TM'=>'993',
        'TN'=>'216',
        'TO'=>'676',
        'TR'=>'90',
        'TT'=>'1868',
        'TV'=>'688',
        'TW'=>'886',
        'TZ'=>'255',
        'UA'=>'380',
        'UG'=>'256',
        'US'=>'1',
        'UY'=>'598',
        'UZ'=>'998',
        'VA'=>'39',
        'VC'=>'1784',
        'VE'=>'58',
        'VG'=>'1284',
        'VI'=>'1340',
        'VN'=>'84',
        'VU'=>'678',
        'WF'=>'681',
        'WS'=>'685',
        'XK'=>'381',
        'YE'=>'967',
        'YT'=>'262',
        'ZA'=>'27',
        'ZM'=>'260',
        'ZW'=>'263'
    ];

    /**
     * @var $responseFactory
     */
    public $responseFactory;

    /**
     * @var $resCollectionFactory
     */
    public $resCollectionFactory;

    /**
     * @var $resolver
     */
    public $resolver;

    /**
     * @var $remoteAddress
     */
    public $remoteAddress;

    /**
     * @var $storeManager
     */
    public $storeManager;

    /**
     * @var $customerFactory
     */
    public $customerFactory;

    /**
     * @var $inlineTranslation
     */
    public $inlineTranslation;

    /**
     * @var $transportBuilder
     */
    public $transportBuilder;

    /**
     * @var $scopeConfigInterface
     */
    public $scopeConfigInterface;

    /**
     * @var $customerSession
     */
    public $customerSession;

    /**
     * @var $_filesystem
     */
    public $_filesystem;

    /**
     * @var $objectFactory
     */
    public $objectFactory;

    /**
     * @var $enable
     */
    public $enable;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var EncryptorInterface
     */
    private $enc;

    /**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface CookieManagerInterface
     */
    private $cookieManager;

    /**
     * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory CookieMetadataFactory
     */
    private $cookieMetadataFactory;

    /**
     * @var \Magento\Integration\Model\Oauth\TokenFactory
     */
    protected $tokenModelFactory;

    /**
     * Function __construct
     *
     * @param    \Webkul\FormBuilder\Model\FormFactory                                  $formFactory,
     * @param    \Webkul\FormBuilder\Model\ResponseFactory                              $responseFactory,
     * @param    \Webkul\FormBuilder\Model\ResourceModel\Response\CollectionFactory     $resCollectionFactory,
     * @param    \Magento\Framework\Locale\Resolver                                     $resolver,
     * @param    \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress                   $remoteAddress,
     * @param    \Magento\Store\Model\StoreManagerInterface                             $storeManager,
     * @param    \Magento\Customer\Model\CustomerFactory                                $customerFactory,
     * @param    \Magento\Framework\Translate\Inline\StateInterface                     $inlineTranslation,
     * @param    \Webkul\FormBuilder\Model\Mail\TransportBuilder                      $transportBuilder,
     * @param    \Magento\Framework\App\Config\ScopeConfigInterface                     $scopeConfigInterface,
     * @param    \Magento\Customer\Model\Session                                        $customerSession
     * @param    \Magento\Framework\Message\ManagerInterface                            $messageManager
     * @param    \Magento\Framework\Filesystem                                          $filesystem
     * @param    \Magento\Framework\Stdlib\DateTime\TimezoneInterface                   $timezoneInterface
     * @param    \Magento\Framework\DataObjectFactory                                   $objectFactory
     * @param    \Magento\Framework\Serialize\SerializerInterface                       $serializer
     * @param    \Magento\Framework\Encryption\EncryptorInterface                       $enc
     * @param    \Magento\Customer\Model\SessionFactor                                  $sessionFactory
     * @param    \Magento\Framework\HTTP\Client\Curl                                    $curl
     */
    public function __construct(
        \Webkul\FormBuilder\Model\FormFactory $formFactory,
        \Webkul\FormBuilder\Model\ResponseFactory $responseFactory,
        \Webkul\FormBuilder\Model\ResourceModel\Response\CollectionFactory $resCollectionFactory,
        \Magento\Framework\Locale\Resolver $resolver,
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Webkul\FormBuilder\Model\Mail\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \Magento\Framework\Encryption\EncryptorInterface $enc,
        \Magento\Customer\Model\SessionFactory $sessionFactory,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory,
        \Magento\Integration\Model\Oauth\TokenFactory $tokenModelFactory
    ) {
        $this->formFactory = $formFactory;
        $this->responseFactory = $responseFactory;
        $this->_localeResolver = $resolver;
        $this->remoteAddress = $remoteAddress;
        $this->_storeManager = $storeManager;
        $this->resCollectionFactory = $resCollectionFactory;
        $this->_customerFactory = $customerFactory;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfigInterface;
        $this->customerSession = $customerSession;
        $this->_messageManager = $messageManager;
        $this->_filesystem = $filesystem;
        $this->_timezoneInterface = $timezoneInterface;
        $this->objectFactory = $objectFactory;
        $this->serializer = $serializer;
        $this->_enc = $enc;
        $this->_curl = $curl;
        $this->sessionFactory = $sessionFactory;
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->tokenModelFactory = $tokenModelFactory;
    }

    /**
     * Function getMediaPath
     *
     * @param int $id
     * @return array
     */
    public function getMediaPath()
    {
        $currentStore = $this->_storeManager->getStore();
        return $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
    
    /**
     * Return Form data of given ID.
     *
     * @param int $id
     * @return array
     */
    public function getFormInfoById($id)
    {
        $form = $this->formFactory->create();
        $result = $form->load($id);
        $result = $result->getData();
        return $result;
    }

    /**
     * Return locale.
     *
     * @return array
     */
    public function getLocale()
    {
        return $this->_localeResolver->getLocale();
    }

    /**
     * Get Form Name By ID.
     *
     * @param int $id
     * @return array
     */
    public function getFormNameById($id)
    {
        $form = $this->formFactory->create();
        $result = $form->load($id);
        $result = $result->getName();
        return $result;
    }

    /**
     * Get Form Name By ID.
     *
     * @param int $id
     * @return array
     */
    public function getFormName($id)
    {
     
        $id = $this->getResponseName($id);
        $form = $this->formFactory->create();
        $result = $form->load($id);
        $result = $result->getName();
        return $result;
    }

    /**
     * Get Response Name By ID.
     *
     * @param int $id
     * @return array
     */
    public function getResponseName($id)
    {
        $response = $this->responseFactory->create();
        $result = $response->load($id);
        $result = $result->getFormId();
        return $result;
    }

    /**
     * Get Customer IP.
     *
     * @return string
     */
    public function getCustomerIp()
    {
        return $this->remoteAddress->getRemoteAddress();
    }

    /**
     * Get Customer Name By ID.
     *
     * @param int $id
     * @return string
     */
    public function getUserNameById($id)
    {
        $customer  = $this->_customerFactory->create()->load($id);
        return $customer->getFirstname()." ".$customer->getLastname();
    }

    /**
     * Get Customer
     *
     * @return string
     */
    public function getCustomer()
    {
        if ($this->customerSession->isLoggedIn()) {
            return  $this->customerSession->getCustomerId();
        } else {
            return null;
        }
    }
    
    /**
     * Get store identifier
     *
     * @return  int
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * Get store identifier
     *
     * @param   int $id
     * @return  int
     */
    public function getStoreNameById($id)
    {
        return $this->_storeManager->getStore($id)->getName();
    }

    /**
     * Get Total Response
     *
     * @param   int $id
     * @return  int
     */
    public function getTotalResponseById($id)
    {
        $collection = $this->resCollectionFactory->create()
                    ->addFieldToFilter('form_id', $id);
        return $collection->getSize();
    }

    /**
     * Send Mail
     *
     * @param   array $data
     * @return  true
     */
    public function sendAdminMail($datafile, $data)
    {
       
        $json  = json_encode($datafile);
        $array = json_decode($json, true);
        
        if ($array != null) {
            $attachmentData = $array['res']['res']['wk_file']['value'];
        } else {
            $attachmentData = '';
        }
        if (!$this->getEmailEnable()) {
            return false;
        }
        // Get the email and Name
        $name = $this->getSenderName();
        $sendingEmail = $this->getSendingEmail();
        $email =  $this->getSenderEmail();
        $htmlVar = $this->makeHtml($data);
        try {
            $transport = $this->transportBuilder
            ->setTemplateIdentifier('formbuilder_email_admin_email')
            ->setTemplateOptions(
                ['area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID]
            )
            ->setTemplateVars(['data' => $htmlVar])
            ->setFrom(['name' => $name,'email' => $sendingEmail])
            ->addTo($email)
            ->addAttachment($attachmentData)
            ->getTransport();
            
            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->_messageManager->addError($e->getMessage());
        }
    }

    /**
     * Make HTML For Mail
     *
     * @param  array $data
     * @return html
     */
    public function makeHtml($data)
    {
        $html = "";
        if (isset($data['response']) && !empty($data['response'])) {
            $responses = $this->jsonDecode($data['response']);
            $html = __("No Data");
            if (isset($responses)) {
                $html = $this->createTable($responses);
            }
        }
        return $html;
    }

    /**
     * Make HTML For Table
     *
     * @param       array $responses
     * @return      html
     */
    public function createTable($responses)
    {
        $html = '<table id="respones">';
        foreach ($responses as $res) {
            if (isset($res->label)) {
                $html .=    '<tr>';
                $html .=        '<th>'.$this->checkEmpty($res->label).'</th>';
                if (isset($res->value)) {
                    if (is_array($res->value)) {
                        $html .=  '<td>'.implode(",", $res->value).'</td>';
                    } else {
                        $html .=  '<td>'.$this->checkEmpty($res->value ?? __("No Data")).'</td>';
                    }
                } else {
                    $html .=  '<td>'.__('No Data').'</td>';
                }
                $html .=    '</tr>';
            }
        }
                
        $html .=  '</table>';
        return $html;
    }

    /**
     *  Encode the array to json
     *
     * @param array $array
     * @return json
     */
    public function jsonEncode($array)
    {
        return json_encode($array);
    }

    /**
     *  Decode the Json to Array
     *
     * @param Json $array
     * @return array
     */
    public function jsonDecode($array)
    {
        return json_decode($array);
    }

    /**
     *  Function to convert array into
     *
     * @param Json $Array
     * @return stdClass object
     */
    public function toObject($Array)
    {
        $object = $this->objectFactory->create();

        // Use loop to convert array into
        // stdClass object
        foreach ($Array as $key => $value) {
            if (is_array($value)) {
                $value = $this->toObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }

    /**
     *  Get Config Value
     *
     * @param string $string
     * @return bool
     */
    public function getConfigValue($string)
    {
        return $this->scopeConfig->getValue(
            $string,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     *  Get Form Builder enable
     *
     * @return bool
     */
    public function getFormEnable()
    {
        return $this->getConfigValue('formbuilder/general_settings/enable');
    }

    /**
     *  Get Email Option enable
     *
     * @return bool
     */
    public function getEmailEnable()
    {
        return $this->getConfigValue('formbuilder/general_settings/emailEnable');
    }

    /**
     *  Get Sender Name
     *
     * @return string
     */
    public function getSenderName()
    {
        return $this->getConfigValue('formbuilder/general_settings/adminName');
    }

    /**
     *  Get Sender Name
     *
     * @return string
     */
    public function getSendingEmail()
    {
        return $this->getConfigValue('formbuilder/general_settings/sendingEmail');
    }

    /**
     *  Get Sender Email
     *
     * @return string
     */
    public function getSenderEmail()
    {
        return $this->getConfigValue('formbuilder/general_settings/adminEmail');
    }

    /**
     * Check Empty Value
     *
     * @param string $string
     * @return string
     */
    public function checkEmpty($string)
    {
        return !empty($string) ? $string : __("No Data");
    }

    /**
     * Function getTimeAccordingToTimeZone
     *
     * @param string $dateTime
     * @return string $dateTime as time zone
     */
    public function getTimeAccordingToTimeZone($dateTime)
    {
        // for get current time according to time zone
        $today = $this->_timezoneInterface->date()->format('m/d/y H:i:s');
 
        // for convert date time according to magento time zone
        $dateTimeAsTimeZone = $this->_timezoneInterface
                                        ->date(new \DateTime($dateTime))
                                        ->format('m/d/y H:i:s');
        return $dateTimeAsTimeZone;
    }

    /**
     * Check Recaptcha Enabled
     *
     * @return Boolen
     */
    public function enableRecaptcha()
    {
        return $this->getConfigValue('formbuilder/general_settings/enableRecaptcha');
    }

    /**
     * Get Encrypted Value
     *
     * @return Boolen
     */
    public function getSiteKey()
    {
        $val = $this->getConfigValue('formbuilder/general_settings/siteKey');
        return $this->_enc->decrypt($val);
    }
    
    /**
     * Get Encrypted Value
     *
     * @return Boolen
     */
    public function getSecretKeyKey()
    {
        $val = $this->getConfigValue('formbuilder/general_settings/secretKey');
        return $this->_enc->decrypt($val);
    }

    /**
     * Check Requested response is exist
     *
     * @param int $id
     * @return Boolen
     */
    public function isResponseExist($id)
    {
        $collection = $this->resCollectionFactory->create()
        ->addFieldToFilter('entity_id', $id);
        if ($collection->getSize()) {
            return true;
        }
    }

     /**
      * Check Requested response is exist
      *
      * @param int $id
      * @return Boolen
      */
    public function isResponseByFormIDExist($id)
    {
        $collection = $this->resCollectionFactory->create()
        ->addFieldToFilter('form_id', $id);
    
        if ($collection->getSize()) {
            return true;
        }
    }

    /**
     * Function TO check the recaptcha token
     *
     * @param Form $token
     * @return Boolen
     */
    public function validateRecaptcha($token)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $params = [
            'secret' => $this->getSecretKeyKey(),
            'response' => $token,
            'remoteip' => $this->getCustomerIp()
        ];
      
        $this->_curl->post($url, $params);
        $response = $this->_curl->getBody();
        $resp = $this->serializer->unserialize(($response));
        
        if ($resp['success']) {
            if (isset($resp['score']) && $resp['score'] > 0.5) {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Function to check that form is enable For a particular form
     *
     * @param int $recaptcha
     * @return bool
     */
    public function checkRecaptcha($recaptcha)
    {
        if ($recaptcha == 1) {
            return true;
        } elseif ($recaptcha == 0) {
            return false;
        } elseif ($recaptcha == 2) {
            return $this->isGuest();
        }
    }
      
    /**
     * Check customer is guest or not
     *
     * @return string
     */
    public function isGuest()
    {
        if (!$this->sessionFactory->create()->isLoggedIn()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getPhoneCode($code)
    {
        return isset(self::COUNTRY_CODE[$code]) ? self::COUNTRY_CODE[$code] : '';
    }

    /** Set Custom Cookie using Magento 2 */
    public function setCustomerPersistentCookie($value)
    {
        $publicCookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata();
        $publicCookieMetadata->setDurationOneYear();
        $publicCookieMetadata->setPath('/');
        $publicCookieMetadata->setHttpOnly(true);

        return $this->cookieManager->setPublicCookie(
            self::COOKIE_NAME,
            $value,
            $publicCookieMetadata
        );
    }

    /** Get Custom Cookie using */
    public function getCustomerPersistentCookie()
    {
        return $this->cookieManager->getCookie(
            self::COOKIE_NAME
        );
    }

    /** Delete Custom Cookie using */
    public function deleteCustomerPersistentCookie()
    {
        $metadata = $this->cookieMetadataFactory->createPublicCookieMetadata();
        $metadata->setPath('/');

        return $this->cookieManager->deleteCookie(
            self::COOKIE_NAME,
            $metadata
        );
    }

    public function verifyCustomerPersistentCookieToken()
    {
        $cookieValue = $this->getCustomerPersistentCookie();
        if ($cookieValue) {
            try {
                $customerId = $this->tokenModelFactory->create()->loadByToken($cookieValue)->getData('customer_id');
                if ($customerId) {
                    $this->sessionFactory->create()->loginById($customerId);
                    if (!$this->customerSession->getCustomer()->getMpCustomerConsent()) {
                        $this->customerSession->getCustomer()->setMpCustomerConsent(1);
                    }
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        return $this->sessionFactory->create()->isLoggedIn();
    }
}
