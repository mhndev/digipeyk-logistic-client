<?php
namespace mhndev\digipeykLogisticClient\entities;

use mhndev\digipeykLogisticClient\iEntityOrder;
use mhndev\digipeykLogisticClient\valueObjects\OrderItem;
use mhndev\digipeykLogisticClient\valueObjects\OrderPrice;
use mhndev\digipeykLogisticClient\valueObjects\OrderStatus;
use mhndev\phpStd\Collection;

/**
 * Class EntityOrder
 * @package mhndev\digipeykLogisticClient\entities
 */
class EntityOrder implements iEntityOrder
{

    /**
     * @var mixed
     */
    protected $identifier;

    /**
     * @var mixed
     */
    protected $ownerIdentifier;

    /**
     * @var OrderStatus
     */
    protected $status;

    /**
     * @var OrderPrice
     */
    protected $price;

    /**
     * @var Collection
     */
    protected $items;

    /**
     * @var bool
     */
    protected $is_locked;


    /**
     * @return mixed string | integer
     */
    function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return mixed
     */
    function getOwnerIdentifier()
    {
        return $this->ownerIdentifier;
    }

    /**
     * @return OrderStatus
     */
    function getStatus(): OrderStatus
    {
        return $this->status;
    }

    /**
     * @return Collection
     */
    function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param OrderItem $orderItem
     * @return iEntityOrder
     */
    function addItem(OrderItem $orderItem): iEntityOrder
    {
        $this->items->add($orderItem);

        $this->price->addTripPrice($orderItem->getPrice());

        return $this;
    }


    /**
     * @return iEntityOrder
     */
    function clearItems(): iEntityOrder
    {
        $this->items = new Collection();

        $this->status = new OrderStatus(OrderStatus::INIT);

        return $this;
    }


    /**
     * @return boolean
     */
    function isLocked(): bool
    {
        return $this->is_locked;
    }

    /**
     * @return iEntityOrder
     */
    function lock(): iEntityOrder
    {
        $this->is_locked = true;

        return $this;
    }

    /**
     * @return iEntityOrder
     */
    function unlock(): iEntityOrder
    {
        $this->is_locked = false;

        return $this;
    }

    /**
     * @return OrderPrice
     */
    public function getPrice(): OrderPrice
    {
        return $this->price;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'identifier'      => $this->getIdentifier(),
            'price'           => $this->getPrice()->toArray(),
            'status'          => $this->getStatus()->toArray(),
            'ownerIdentifier' => $this->getOwnerIdentifier(),
            'is_locked'       => $this->isLocked(),
            'items'           => $this->getItems()->toArray()
        ];
    }
}
