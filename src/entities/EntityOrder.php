<?php
namespace mhndev\digipeykLogisticClient\entities;

use mhndev\digipeykLogisticClient\interfaces\iEntity;
use mhndev\digipeykLogisticClient\interfaces\iEntityOrder;
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

    use ObjectBuilder{
        fromOptions as parentFromOptions;
    }


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
    protected $is_locked = false;

    /**
     * @var bool
     */
    protected $is_paid = false;

    /**
     * @var OrderPayment | null
     */
    protected $payment;

    /**
     * @var \DateTime
     */
    protected $created_at;


    /**
     * @var \DateTime
     */
    protected $updated_at;


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
        return empty($this->items) ? new Collection() : $this->items;
    }


    /**
     * @param Collection $items
     * @return $this
     */
    function setItems(Collection $items)
    {
        $this->items = $items;

        return $this;
    }


    /**
     * @param OrderItem $orderItem
     * @return iEntityOrder
     */
    function addItem(OrderItem $orderItem): iEntityOrder
    {
        $this->setItems($this->getItems()->add($orderItem));

        $this->setPrice($this->getPrice()->addTripPrice($orderItem->getPrice()));

        return $this;
    }


    /**
     * @return iEntityOrder
     */
    function clearItems(): iEntityOrder
    {
        $this->items = new Collection();

        $this->getPrice()->reset();

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
        return empty($this->price) ? new OrderPrice(0, 0) : $this->price;
    }

    /**
     * @param OrderPrice $price
     * @return $this
     */
    public function setPrice(OrderPrice $price)
    {
        $this->price = $price;

        return $this;
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
            'payment'         => !empty($this->getPayment()) ? $this->getPayment()->toArray() : null,
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
     * @return OrderPayment | null
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

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param array $array
     * @return static
     */
    public static function fromOptions(array $array)
    {
        return self::parentFromOptions(self::fixArrayData($array));
    }

    /**
     * @param array $array
     * @return array
     */
    private static function fixArrayData(array $array)
    {
        $items = new Collection();
        foreach ($array['items'] as $item){
            $orderItem = OrderItem::fromOptions($item);

            $items->add($orderItem);
        }

        $array['items'] = $items;
        $array['price'] = OrderPrice::fromOptions($array['price']);
        if (empty($array['status'])){
            $array['status'] = new OrderStatus(OrderStatus::INIT);
        }
        else{
            $array['status'] = new OrderStatus($array['status']['code']);
        }

        return $array;
    }


    /**
     * @param array $array
     * @return iEntity
     */
    function fromArray(array $array)
    {
        return self::fromOptions($array);
    }

    /**
     * @return array
     */
    function preview()
    {
        // TODO: Implement preview() method.
    }

}
