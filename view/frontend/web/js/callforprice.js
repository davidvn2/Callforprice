define([
    "jquery",
    "magehit_fancybox",
    "jquery/ui",
    "uiRegistry"
], function ($, fancybox, ui, registry) {
	"use strict";
	$.widget("mage.callforprice", {
		options: {
			productId: '',
			buttonTitle: '',
			loadformurl: '',
			itemSelector: '',
			priceElementSelector: '',
			cartButtonElementSelector: '',
			btnActionId: 'callforpriceBtn',
			modeView : '',
			classActionButton : '',
			productType : '',
			buttonCustomClass : 'callforprice-btn',
			autoSubmit: false
		},
		selects: [],
        _create: function() {
			var self = this, options = this.options;
			var buttonId = this.options.btnActionId + "_" + this.options.productId;
			var buttonHtml = '<button id="'+ buttonId +'" type="button" class="'+ this.options.buttonCustomClass +'" title="'+ this.options.buttonTitle +'">'+ this.options.buttonTitle +'</button>';
			if(this.element) this.element.parents(this.options.itemSelector).find(this.options.priceElementSelector).remove();
			if(this.element) this.element.parents(this.options.itemSelector).find(this.options.cartButtonElementSelector).remove();
			if(this.options.classActionButton == 'form'){
				if(this.element) this.element.parents(this.options.itemSelector).find(this.options.classActionButton).attr('action','');
			}
			if(this.element) this.element.parents(this.options.itemSelector).find(this.options.classActionButton).append(buttonHtml);
			if(this.options.productType == 'bundle'){
				if(this.element) this.element.parents(this.options.itemSelector).parent().find('.bundle-options-container').find(this.options.priceElementSelector).remove();	
				if(this.element) this.element.parents(this.options.itemSelector).parent().find('.bundle-options-container').find(this.options.cartButtonElementSelector).remove();	
				if(this.element) this.element.parents(this.options.itemSelector).parent().find('.bundle-options-container .block-bundle-summary').append(buttonHtml);
			}
			$(this.element).parents(this.options.itemSelector).find('.' + this.options.buttonCustomClass).click(function () {
                self.loadCallForPriceFormFromListProduct();
            });
			if(this.options.modeView == 'wishlist_index_index'){
				$('#wishlist-view-form .actions-toolbar .tocart').addClass('disabled');
			}
			
        },
		loadCallForPriceFormFromListProduct: function(){
			$.fancybox({
				href: this.options.loadformurl,
				type: "ajax",
				ajax: {
					dataType : 'json',
					type: "POST",
					data: {proId: this.options.productId}
				},
				helpers : {
					overlay : {
						locked : true // try changing to true and scrolling around the page
					}
				},
				maxWidth  : '80%',
				width     : '350px',
				fitToView : false,
				centerOnScroll : true,
				scrollOutside : false
			});
		}
	});
	return $.mage.callforprice;
});

