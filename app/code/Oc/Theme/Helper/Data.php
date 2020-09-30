<?php
namespace Oc\Theme\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_customerSession;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\Session $customerSession
    ) 
    {
        $this->_customerSession = $customerSession; 
        parent::__construct($context);   
    }

    public function getCustomerId()
    {
        //return current customer ID
        return $this->_customerSession->getId();
    }
	
	public function getConfig($config_path)
	{
		return $this->scopeConfig->getValue(
				$config_path,
				\Magento\Store\Model\ScopeInterface::SCOPE_STORE
				);
	}		
}