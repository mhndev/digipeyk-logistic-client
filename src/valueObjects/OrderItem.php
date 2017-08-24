<?php
namespace mhndev\digipeykLogisticClient\valueObjects;

use mhndev\valueObjects\interfaces\iValueObject;

/**
 * Class OrderItem
 * @package mhndev\digipeykLogisticClient\valueObjects
 */
class OrderItem implements iValueObject
{

    /**
     * @var OrderItemSource
     */
    protected $itemSource;

    /**
     * @var OrderItemDestination
     */
    protected $itemDestination;

    /**
     * @var integer
     */
    protected $price;


    /**
     * OrderItem constructor.
     * @param OrderItemSource $itemSource
     * @param OrderItemDestination $itemDestination
     * @param integer $price
     */
    function __construct(
        OrderItemSource $itemSource,
        OrderItemDestination $itemDestination,
        $price
    )
    {
        $this->itemSource = $itemSource;
        $this->itemDestination = $itemDestination;
        $this->price = $price;
    }

    /**
     * @param iValueObject $valueObject
     * @return boolean
     */
    function isEqual(iValueObject $valueObject)
    {
        /** @var OrderItem $givenOrderItem */
        $givenOrderItem = $valueObject;

        return
            ( $this->getPrice() == $givenOrderItem->getPrice() ) &&
            ( $this->itemSource->isEqual($givenOrderItem->getItemSource() ) ) &&
            ( $this->itemDestination->isEqual($givenOrderItem->getItemDestination() ) );
    }


    /**
     * @return OrderItemSource
     */
    public function getItemSource(): OrderItemSource
    {
        return $this->itemSource;
    }

    /**
     * @return OrderItemDestination
     */
    public function getItemDestination(): OrderItemDestination
    {
        return $this->itemDestination;
    }

    /**
     * @return integer
     */
    public function getPrice(): integer
    {
        return $this->price;
    }


    /**
     * @return array
     */
    function toArray()
    {
        return [
            'source'      => $this->getItemSource()->toArray(),
            'destination' => $this->getItemDestination()->toArray(),
            'price'       => $this->getPrice()
        ];
    }


}
