<?php
namespace Magehit\Callforprice\Block\Product;
 
class NewProduct extends \Magento\Catalog\Block\Product\NewProduct
{
	public function getProductPriceHtml(
        \Magento\Catalog\Model\Product $product,
        $priceType,
        $renderZone = \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
        array $arguments = []
    ) {
		$html = $this->getLayout()->createBlock('Magento\Framework\View\Element\Template')->assign('product',$product)->setTemplate('Magehit_Callforprice::button.phtml')->toHtml();
        
        if (!isset($arguments['zone'])) {
            $arguments['zone'] = $renderZone;
        }

        /** @var \Magento\Framework\Pricing\Render $priceRender */
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');
        $price = '';

        if ($priceRender) {
            $price = $priceRender->render($priceType, $product, $arguments);
        }

        return $price . $html;
    }
}
