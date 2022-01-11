<?php
namespace Magehit\Callforprice\Block\Product\Compare;
 
class ListCompare extends \Magento\Catalog\Block\Product\Compare\ListCompare
{
	 /**
     * Render price block
     *
     * @param Product $product
     * @param string|null $idSuffix
     * @return string
     */
    public function getProductPrice(\Magento\Catalog\Model\Product $product, $idSuffix = '')
    {
		$html = $this->getLayout()->createBlock('Magento\Framework\View\Element\Template')->assign('product',$product)->setTemplate('Magehit_Callforprice::button.phtml')->toHtml();
        /** @var \Magento\Framework\Pricing\Render $priceRender */
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                $product,
                [
                    'price_id' => 'product-price-' . $product->getId() . $idSuffix,
                    'display_minimal_price' => true,
                    'zone' => \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
                ]
            );
        }
        return $price . $html;
    }
}
