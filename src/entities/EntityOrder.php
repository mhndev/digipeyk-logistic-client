<?php
namespace mhndev\digipeykLogisticClient\entities;

use mhndev\digipeykLogisticClient\iEntityOrder;
use mhndev\digipeykLogisticClient\valueObjects\OrderEvent;
use mhndev\digipeykLogisticClient\valueObjects\OrderItem;
use mhndev\digipeykLogisticClient\valueObjects\OrderPayment;
use mhndev\digipeykLogisticClient\valueObjects\OrderPrice;
use mhndev\digipeykLogisticClient\valueObjects\OrderStatus;
use mhndev\phpStd\Collection;
use mhndev\phpStd\ObjectBuilder;

/**
 * Class EntityOrder
 * @package mhndev\digipeykLogisticClient\entities
 */
class EntityOrder implements iEntityOrder
{

    use ObjectBuilder;


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
     * @var bool
     */
    protected $is_paid;

    /**
     * @var OrderPayment
     */
    protected $payment;

    /**
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @var array of OrderEvent
     */
    protected $events;


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
            'is_paid'         => $this->isPaid(),
            'payment'         => $this->getPayment()->toArray(),
            'items'           => $this->getItems()->toArray()
        ];
    }

    /**
     * @return bool
     */
    function isPaid()
    {
        return $this->is_paid;
    }

    /**
     * @return OrderPayment
     */
    function getPayment()
    {
        return $this->payment;
    }


    /**
     * @param OrderEvent $event
     * @return $this
     */
    function addEvent(OrderEvent $event)
    {
        $this->events[] = $event;

        return $this;
    }


    /**
     * @param OrderPayment $payment
     * @return $this
     */
    function pay(OrderPayment $payment)
    {
        $this->payment = $payment;

        return $this;
    }

}
