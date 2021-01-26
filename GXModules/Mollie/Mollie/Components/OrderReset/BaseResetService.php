<?php


namespace Mollie\Gambio\OrderReset;


use Mollie\Gambio\Entity\Repository\GambioOrderProductRepository;
use Mollie\Gambio\Entity\Repository\GambioProductAttributesRepository;
use Mollie\Gambio\Entity\Repository\GambioProductPropertiesCombisRepository;
use Mollie\Gambio\Entity\Repository\GambioProductRepository;
use Mollie\Gambio\Entity\Repository\GambioSpecialsRepository;

abstract class BaseResetService
{
    /**
     * @var GambioProductRepository
     */
    protected $productRepository;
    /**
     * @var GambioProductAttributesRepository
     */
    protected $productAttributesRepository;
    /**
     * @var GambioProductPropertiesCombisRepository
     */
    protected $productPropertiesCombisRepository;
    /**
     * @var GambioSpecialsRepository
     */
    protected $specialsRepository;
    /**
     * @var GambioOrderProductRepository
     */
    protected $orderProductRepository;

    /**
     * BaseResetService constructor.
     */
    public function __construct()
    {
        $this->productRepository = new GambioProductRepository();
        $this->productAttributesRepository = new GambioProductAttributesRepository();
        $this->productPropertiesCombisRepository = new GambioProductPropertiesCombisRepository();
        $this->specialsRepository = new GambioSpecialsRepository();
        $this->orderProductRepository = new GambioOrderProductRepository();
    }


    /**
     * @param int $combisCount
     * @param array $order
     *
     * @return int
     */
    protected function getUseCombisCount($combisCount, $order)
    {
        if($combisCount > 0) {
            $combisAdminControl = \MainFactory::create_object("PropertiesCombisAdminControl");

            return (int)$combisAdminControl->get_use_properties_combis_quantity($order['products_id']);
        }

        return 0;
    }
}