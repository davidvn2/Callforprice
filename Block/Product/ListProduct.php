<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Block\Product;
 
class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
	public function getProductPrice(\Magento\Catalog\Model\Product $product)
    {
		$html = $this->getLayout()->createBlock('Magento\Framework\View\Element\Template')->assign('product',$product)->setTemplate('V2Agency_Callforprice::button.phtml')->toHtml();
        $priceRender = $this->getPriceRender();
        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                $product,
                [
                    'include_container' => true,
                    'display_minimal_price' => true,
                    'zone' => \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
                    'list_category_page' => true
                ]
            );
        }
        return $price . $html;
    }
}