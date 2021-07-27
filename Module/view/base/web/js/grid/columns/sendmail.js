define([
    'Magento_Ui/js/grid/columns/column',
    'jquery',
    'mage/template',
    'text!Preorder_Module/templates/grid/cells/customer/sendmail.html',
    'Magento_Ui/js/modal/modal'
], function (Column, $, mageTemplate, sendmailPreviewTemplate) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'ui/grid/cells/html',
            fieldClass: {
                'data-grid-html-cell': true
            }
        },
        gethtml: function (row) {
            return row[this.index + '_html'];
        },
        getFormaction: function (row) {
            return row[this.index + '_formaction'];
        },
        getCustomerid: function (row) {
            return row[this.index + '_customerid'];
        },
        getLabel: function (row) {
            return row[this.index + '_html']
        },
        getTitle: function (row) {
            return row[this.index + '_title']
        },
        getSubmitlabel: function (row) {
            return row[this.index + '_submitlabel']
        },
        getCancellabel: function (row) {
            return row[this.index + '_cancellabel']
        },
        gettype: function (row) {
            return row[this.index + '_type']
        },
        getcomments: function (row) {
            return row[this.index + '_comments']
        },    
        getemail: function (row) {
            return row[this.index + '_email']
        },  
        getproduct: function (row) {
            return row[this.index + '_product']
        },     
        getsku: function (row) {
            return row[this.index + '_sku']
        },                                    
        preview: function (row) {
            var modalHtml = mageTemplate(
                sendmailPreviewTemplate,
                {
                    html: this.gethtml(row), 
                    title: this.getTitle(row), 
                    label: this.getLabel(row), 
                    formaction: this.getFormaction(row),
                    customerid: this.getCustomerid(row),
                    submitlabel: this.getSubmitlabel(row), 
                    cancellabel: this.getCancellabel(row), 
                    linkText: $.mage.__('Go to Details Page'),
                    type: this.gettype(row), 
                    email: this.getemail(row), 
                    comments: this.getcomments(row),
                    product: this.getproduct(row),
                    sku: this.getsku(row),
                }
            );
            var previewPopup = $('<div/>').html(modalHtml);
            previewPopup.modal({
                title: this.getTitle(row),
                innerScroll: true,
                modalClass: '_image-box',
                buttons: []}).trigger('openModal');
        },
        getFieldHandler: function (row) {
            return this.preview.bind(this, row);
        }
    });
});