<?php

namespace Mollie\Gambio\OrderReset;

/**
 * Class RestockService
 *
 * @package Mollie\Gambio\OrderReset
 */
class RestockService extends BaseResetService
{

    /**
     * @param array $order
     * @param int $orderId
     */
    public function restock($order, $orderId)
    {
        if($this->specialsRepository->countByProductAndDate($order['products_id'], $order['date_purchased']) > 0) {
            $this->specialsRepository->increaseProductsQuantity($order['products_id'], $order['products_quantity']);
        }

        $combisCount = $this->productPropertiesCombisRepository->countByProductId($order['products_id']);
        $useCombisQuantity = $this->getUseCombisCount($combisCount, $order);


        if($this->isChangedProductStock($combisCount, $useCombisQuantity, $order)) {
            $this->productRepository->increaseProductQuantity($order['products_id'], $order['products_quantity']);
        }

        $this->productRepository->decreaseProductOrderedQuantity($order['products_id'], $order['products_quantity']);
        if($this->increaseCombisQuantity($combisCount, $useCombisQuantity)) {
            $this->productPropertiesCombisRepository->increaseCombiQuantity(
                $order['products_id'],
                $order['products_properties_combis_id'],
                $order['products_quantity']
            );
        }

        if(ATTRIBUTE_STOCK_CHECK == 'true') {
            $this->increaseAttributesStock($orderId, $order);
        }
    }

    /**
     * @param int $combisCount
     * @param int $useCombisQuantity
     *
     * @return bool
     */
    private function increaseCombisQuantity($combisCount, $useCombisQuantity)
    {
        if ($this->isVersion4()) {
            return $combisCount > 0 &&
                (
                    ($useCombisQuantity === \PropertiesCombisAdminControl::DEFAULT_GLOBAL && STOCK_CHECK == 'true' && ATTRIBUTE_STOCK_CHECK == 'true') ||
                    $useCombisQuantity === \PropertiesCombisAdminControl::COMBI_STOCK
                );
        }

        return $combisCount > 0 &&
            (
                ((int)$useCombisQuantity === 0 && STOCK_CHECK == 'true' && ATTRIBUTE_STOCK_CHECK == 'true') ||
                (int)$useCombisQuantity === 2
            );
    }

    /**
     * @param int $orderId
     * @param array $order
     */
    private function increaseAttributesStock($orderId, $order)
    {
        $ordersAttributes = $this->productAttributesRepository->getOrdersAttributes($orderId, $order['orders_products_id']);
        foreach ($ordersAttributes as $ordersAttribute) {
            $productAttributesId = $this->productAttributesRepository->getProductAttributesId($order['products_id'], $ordersAttribute['products_options'], $ordersAttribute['products_options_values']);
            if($productAttributesId) {
                $this->productAttributesRepository->increaseAttributesStock($productAttributesId, $order['products_quantity']);
            }
        }
    }

    /**
     * @param int $combisCount
     * @param int $useCombisQuantity
     * @param array $order
     *
     * @return bool
     */
    private function isChangedProductStock($combisCount, $useCombisQuantity, $order)
    {
        if ($this->isVersion4()) {
            /** @var \ProductStockService $stockService */
            $stockService = \MainFactory::create('ProductStockService');

            return $stockService->isChangeProductStock(
                $useCombisQuantity,
                (int)$order['products_properties_combis_id'],
                $order['products_attributes_filename']
            );
        }

        return (int)$combisCount === 0 ||
            (int)$useCombisQuantity === 1 ||
            ((int)$useCombisQuantity === 0 && STOCK_CHECK == 'true' && ATTRIBUTE_STOCK_CHECK != 'true');
    }
}
