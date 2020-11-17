/**
 * @category   MagePsycho
 * @package    MagePsycho_ShipTo
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

define([
    'jquery',
    'ko',
    'Magento_Ui/js/form/form',
    'MagePsycho_ShipTo/js/action/updateCountry',
    'Magento_Customer/js/customer-data',
    'MagePsycho_ShipTo/js/model/popup',
    'mage/translate',
    'mage/url',
    'Magento_Ui/js/modal/alert',
    'mage/validation'
], function ($, ko, Component, updateCountryAction, customerData, shiptoPopup, $t, url, alert) {
    'use strict';

    return Component.extend({
        modalWindow: null,
        isLoading: ko.observable(false),
        allowedCountries: window.shiptoPopup.allowedCountries,

        defaults: {
            template: 'MagePsycho_ShipTo/popup',
            selectedCountryId: null
        },

        /**
         * Init
         */
        initialize: function () {
            var self = this;
            this._super();
            url.setBaseUrl(window.shiptoPopup.baseUrl);

            updateCountryAction.registerUpdateCountryCallback(function () {
                self.isLoading(false);
            });
        },

        /** @inheritdoc */
        initObservable: function () {
            var shipto = customerData.get('shipto');
            this._super()
                .observe({
                    selectedCountryId: shipto().country_id
                });
            return this;
        },

        /** Init popup window */
        setModalElement: function (element) {
            if (shiptoPopup.modalWindow == null) {
                shiptoPopup.createPopUp(element);
            }
        },

        /** Is ShipTo option enabled for current customer */
        isActive: function () {
            return window.shiptoPopup.isActive;
        },

        /** Show popup window */
        showModal: function () {
            if (this.modalWindow) {
                $(this.modalWindow).modal('openModal');
            } else {
                alert({
                    content: $t('Unable to open the ShipTo Popup')
                });
            }
        },

        closeModal: function () {
            if (this.modalWindow) {
                $(this.modalWindow).modal('closeModal');
            }
        },

        /**
         * Provide update country action
         *
         * @return {Boolean}
         */
        updateCountry: function (formUiElement, event) {
            var countryData = {},
                formElement = $(event.currentTarget),
                formDataArray = formElement.serializeArray();

            event.stopPropagation();
            formDataArray.forEach(function (entry) {
                countryData[entry.name] = entry.value;
            });

            if (formElement.validation() &&
                formElement.validation('isValid')
            ) {
                this.isLoading(true);
                updateCountryAction(countryData, null, false);
            }
            return false;
        },

        getAllowedCountries: function() {
            return _.map(this.allowedCountries, function (value, key) {
                return {
                    'value': key,
                    'label': value
                };
            });
        }
    });
});
