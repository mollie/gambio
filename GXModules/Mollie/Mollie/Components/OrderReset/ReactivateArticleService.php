<?php


namespace Mollie\Gambio\OrderReset;

/**
 * Class ReactivateArticleService
 *
 * @package Mollie\Gambio\OrderReset
 */
class ReactivateArticleService extends BaseResetService
{

    public function reactivate($order)
    {
        if ($this->reactivateProduct($order)) {
            $setProduct = new \GMDataObject('products');
            $setProduct->set_keys(['products_id' => $order['products_id']]);
            $setProduct->set_data_value('products_status', 1);
            $setProduct->save_body_data();
        }
    }

    /**
     * @param $order
     *
     * @return bool
     */
    private function reactivateProduct($order)
    {
        $combisCount = $this->productPropertiesCombisRepository->countByProductId($order['products_id']);
        $useCombisQuantity = $this->getUseCombisCount($combisCount, $order);

        if ($this->combisNotExists($combisCount, $useCombisQuantity)) {
            $getProduct = new \GMDataObject('products', ['products_id' => $order['products_id']]);
            if ($getProduct->get_data_value('products_quantity') > 0 && $getProduct->get_data_value('products_status') == 0) {
                return true;
            }
        }

        if ($this->combisExists($combisCount, $useCombisQuantity)) {
            $propertiesControl = \MainFactory::create_object('PropertiesControl');

            return $propertiesControl->available_combi_exists($order['products_id']);
        }

        return false;
    }

    private function combisNotExists($combisCount, $useCombisQuantity)
    {
        return $combisCount === 0 ||
            $useCombisQuantity === 1 ||
            ($useCombisQuantity == 0 && STOCK_CHECK == 'true' && ATTRIBUTE_STOCK_CHECK != 'true');
    }

    /**
     * @param int $combisCount
     * @param int $useCombisQuantity
     *
     * @return bool
     */
    private function combisExists($combisCount, $useCombisQuantity)
    {
        return $combisCount > 0 &&
            (
                ($useCombisQuantity == 0 && STOCK_CHECK == 'true' && ATTRIBUTE_STOCK_CHECK == 'true') ||
                $useCombisQuantity == 2
            );
    }
}