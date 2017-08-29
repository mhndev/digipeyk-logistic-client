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
        int $price
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
    public function getPrice(): int
    {
        return $this->price;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'itemSource'      => $this->getItemSource()->toArray(),
            'itemDestination' => $this->getItemDestination()->toArray(),
            'price'       => $this->getPrice()
        ];
    }

    /**
     * @return array
     */
    public function preview()
    {
        return [
            'itemSource'      => $this->getItemSource()->preview(),
            'itemDestination' => $this->getItemDestination()->preview(),
            'price'       => $this->getPrice()
        ];
    }

    public static function fromOptions($data)
    {
        return new static(
            OrderItemSource::fromOptions($data['itemSource']),
            OrderItemDestination::fromOptions($data['itemDestination']),
            $data['price']
        );
    }

}
