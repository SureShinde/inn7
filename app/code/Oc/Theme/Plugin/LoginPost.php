<?php

/**
 *
 */
namespace Oc\Theme\Plugin;

/**
 *
 */
class LoginPost
{

    /**
     * Change redirect after login to home instead of dashboard.
     *
     * @param \Magento\Customer\Controller\Account\LoginPost $subject
     * @param \Magento\Framework\Controller\Result\Redirect $result
     */
    public function afterExecute(
        \Magento\Customer\Controller\Account\LoginPost $subject,
        $result)
    {
		//var_dump($subject);
		//die('1');
    }

}