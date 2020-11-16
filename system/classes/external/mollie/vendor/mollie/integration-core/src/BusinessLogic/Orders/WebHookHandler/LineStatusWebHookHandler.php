<?php

namespace Mollie\BusinessLogic\Orders\WebHookHandler;

use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Integration\Interfaces\OrderLineTransitionService;
use Mollie\BusinessLogic\WebHook\OrderChangedWebHookEvent;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class LineStatusWebHookHandler
 *
 * @package Mollie\BusinessLogic\Orders\WebHookHandler
 */
class LineStatusWebHookHandler
{
    private static $STATUS_TO_SERVICE_METHOD = array(
        'paid' => 'payOrderLine',
        'canceled' => 'cancelOrderLine',
        'authorized' => 'authorizeOrderLine',
        'completed' => 'completeOrderLine',
    );

    /**
     * @param OrderChangedWebHookEvent $event
     * @param bool $forceExecution
     */
    public function handle(OrderChangedWebHookEvent $event, $forceExecution = false)
    {
        if (!$forceExecution && $event->getCurrentOrder()->getStatus() !== $event->getNewOrder()->getStatus()) {
            return;
        }

        /** @var OrderLine[] $newOrderLineMap */
        $newOrderLineMap = array();
        foreach ($event->getNewOrder()->getLines() as $line) {
            $newOrderLineMap[$line->getId()] = $line;
        }

        foreach ($event->getCurrentOrder()->getLines() as $currentLine) {
            if (!array_key_exists($currentLine->getId(), $newOrderLineMap)) {
                continue;
            }

            $newLineStatus = $newOrderLineMap[$currentLine->getId()]->getStatus();
            if ($currentLine->getStatus() === $newLineStatus) {
                continue;
            }

            $serviceMethod = $this->getServiceMethodFor($newLineStatus);
            if (!$serviceMethod) {
                continue;
            }

            call_user_func(
                array($this->getOrderLineTransitionService(), $serviceMethod),
                $event->getOrderReference()->getShopReference(),
                $newOrderLineMap[$currentLine->getId()]
            );
        }
    }

    /**
     * @param string $status
     *
     * @return string|null
     */
    protected function getServiceMethodFor($status)
    {
        return array_key_exists($status, static::$STATUS_TO_SERVICE_METHOD) ? static::$STATUS_TO_SERVICE_METHOD[$status] : null;
    }

    /**
     * @return OrderLineTransitionService
     */
    protected function getOrderLineTransitionService()
    {
        /** @var OrderLineTransitionService $orderTransitionService */
        $orderTransitionService = ServiceRegister::getService(OrderLineTransitionService::CLASS_NAME);
        return $orderTransitionService;
    }
}
