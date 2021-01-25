<?php


namespace Mollie\Gambio\OrderReset;

/**
 * Class OrderResetService
 *
 * @package Mollie\Gambio\OrderReset
 */
class OrderResetService extends BaseResetService
{

    /**
     * @var ReshipService
     */
    private $reshipService;
    /**
     * @var RestockService
     */
    private $restockService;
    /**
     * @var ReactivateArticleService
     */
    private $reactivateArticleService;

    /**
     * OrderResetService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->reshipService = new ReshipService();
        $this->restockService = new RestockService();
        $this->reactivateArticleService = new ReactivateArticleService();
    }


    /**
     *
     * @param int $orderId
     */
    public function resetOrder($orderId)
    {
        $orders = $this->orderProductRepository->getOrderProductsWithAttributes($orderId);

        foreach ($orders as $order) {
            $this->restockService->restock($order, $orderId);
            $this->reactivateArticleService->reactivate($order);
            $this->reshipService->reship($order);
        }

        $deleteHistoryService = \DeleteHistoryServiceFactory::writeService();
        $deleteHistoryService->reportDeletion(\DeletedId::create($orderId), \DeleteHistoryScope::orders());
    }
}
