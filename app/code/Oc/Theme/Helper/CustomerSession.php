<?php
namespace Oc\Theme\Helper;

class CustomerSession extends \Magento\Framework\App\Helper\AbstractHelper
{
	
	/**
	 * @var \Magento\Framework\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var \Magento\Customer\Model\SessionFactory
	 */
	protected $customerSession;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
         \Magento\Framework\ObjectManagerInterface $objectManager
    )
    {
        $this->objectManager   = $objectManager;
        $this->customerSession = $this->objectManager->create('Magento\Customer\Model\SessionFactory')->create();
    }

    /**
     * @return \Magento\Customer\Model\SessionFactory
     */
    public function getCustomerSession()
    {
       return $this->customerSession;     
    }

    /**
     * @return bool
     */
    public function isCustomerLoggedIn()
    {
        return ($this->getCustomerSession()->isLoggedIn()) ? true : false;
    }
}
?>