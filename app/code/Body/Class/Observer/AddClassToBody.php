<?php
namespace Body\Addclass\Observer;

use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Framework\Event\ObserverInterface;

class AddClassToBody implements ObserverInterface
{
    protected $pageConfig;
    protected $_storeManager;

    public function __construct(
        PageConfig $pageConfig, 
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ){
        $this->pageConfig = $pageConfig;
        $this->_storeManager = $storeManager;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
		$direction = $this->helper('Oc\Theme\Helper\Data')->getConfig('general_oc/main_group/direction');
        $store_code = $this->_storeManager->getStore()->getCode();
        $bodyClass = 'store-'.$store_code.' dir-'.$direction;
        $this->pageConfig->addBodyClass($bodyClass);   
    }
}