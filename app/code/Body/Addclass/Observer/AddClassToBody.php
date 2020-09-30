<?php
namespace Body\Addclass\Observer;

use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Framework\Event\ObserverInterface;

class AddClassToBody implements ObserverInterface
{
    protected $pageConfig;
    protected $_storeManager;
	protected $dataHelper;

    public function __construct(
        PageConfig $pageConfig, 
        \Magento\Store\Model\StoreManagerInterface $storeManager,
		\Oc\Theme\Helper\Data $dataHelper
    ){
        $this->pageConfig = $pageConfig;
        $this->_storeManager = $storeManager;
		$this->dataHelper  = $dataHelper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
		$direction = $this->dataHelper->getConfig('general_oc/main_group/direction');
        $store_code = $this->_storeManager->getStore()->getCode();
        $bodyClass = 'store-'.$store_code;
		$bodyClass2 = 'dir-'.$direction;
        $this->pageConfig->addBodyClass($bodyClass);   
		$this->pageConfig->addBodyClass($bodyClass2); 
    }
}