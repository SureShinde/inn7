/**
 * @category   MagePsycho
 * @package    MagePsycho_ShipTo
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/*global define*/
define(
    [
        'jquery',
        'mage/storage',
        'Magento_Ui/js/model/messageList',
        'Magento_Customer/js/customer-data',
        'Magento_Checkout/js/model/step-navigator',
        'mage/translate'
    ],
    function($, storage, globalMessageList, customerData, stepNavigator, $t) {
        'use strict';
        var callbacks = [],
            action = function(countryData, redirectUrl, isGlobal, messageContainer) {
                messageContainer = messageContainer || globalMessageList;
                return storage.post(
                    'shipto/ajax/changeCountry',
                    JSON.stringify(countryData),
                    isGlobal
                ).done(function (response) {

                    if (response.errors === undefined) {
                        messageContainer.addErrorMessage({ message: 'Exception Occurred. Please try again.' });
                        callbacks.forEach(function(callback) {
                            callback(countryData);
                        });
                    } else if (response.errors) {
                        messageContainer.addErrorMessage({ message: response.message });
                        callbacks.forEach(function(callback) {
                            callback(countryData);
                        });
                    } else {
                        /*messageContainer.addSuccessMessage(response.message);*/
                        callbacks.forEach(function(callback) {
                            callback(countryData);
                        });

                        customerData.invalidate(['shipto']);
                        customerData.invalidate(['checkout-data']);

                        if (response.redirectUrl) {
                            window.location.href = response.redirectUrl;
                        } else if (redirectUrl) {
                            window.location.href = redirectUrl;
                        } else {
                            location.reload();
                        }
                    }
                }).fail(function () {
                    messageContainer.addErrorMessage({'message': 'Could not perform the operation. Please try again later'});
                    callbacks.forEach(function(callback) {
                        callback(countryData);
                    });
                });
            };

        action.registerUpdateCountryCallback = function(callback) {
            callbacks.push(callback);
        };

        return action;
    }
);
