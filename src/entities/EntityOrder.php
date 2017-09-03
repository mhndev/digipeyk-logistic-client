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

    use ObjectBuilder {
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
     * @var array
     */
    protected $options;


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
    function getStatus()
    {
        return $this->status;
    }

    /**
     * @return Collection
     */
    function getItems()
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
    public function getPrice()
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
            'identifier' => $this->getIdentifier(),
            'price' => $this->getPrice()->toArray(),
            'status' => $this->getStatus()->toArray(),
            'ownerIdentifier' => $this->getOwnerIdentifier(),
            'is_locked' => $this->isLocked(),
            'is_paid' => $this->isPaid(),
            'payment' => !empty($this->getPayment()) ? $this->getPayment()->toArray() : null,
            'items' => $this->getItems()->toArray()
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
     * @param bool $status
     */
    function setIsPaid(bool $status)
    {
        $this->is_paid = $status;
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
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
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
        foreach ($array['items'] as $item) {
            $orderItem = OrderItem::fromOptions($item);

            $items->add($orderItem);
        }

        $array['items'] = $items;
        $array['price'] = OrderPrice::fromOptions($array['price']);
        if (empty($array['status'])) {
            $array['status'] = OrderStatus::fromOptions(OrderStatus::INIT);
        } else {
            $array['status'] = OrderStatus::fromOptions($array['status']['code']);
        }
        $array['payment'] = OrderPayment::fromOptions($array['payment']);

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
        return [
            'identifier' => $this->getIdentifier(),
            'options' => $this->getOptions(),
            'status'  => $this->getStatus()->preview(),
            'items' => $this->getItems()->preview(),
            'price' => $this->getPrice()->preview(),
            'payment' => $this->getPayment()->preview(),
            'ownerIdentifier' => $this->getOwnerIdentifier(),
            'is_locked' => $this->isLocked(),
            'is_paid' => $this->isPaid(),
            'events'  => OrderEvent::arrayPreview($this->getEvents())


        ];
    }

    /**
     * @param mixed $identifier
     * @return mixed|void
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt(\DateTime $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @param OrderStatus $status
     */
    public function setStatus(OrderStatus $status)
    {
        $this->status = $status;
    }

    /**
     * @param OrderPayment|null $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    public function isEditable()
    {
        return !$this->isLocked();
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param array $events
     */
    public function setEvents(array $events = null)
    {
        $this->events = $events;
    }

    /**
     * @return array
     */
    public function toDigipeykArray()
    {
        $items = $this->getItems();
        $digipeykItems = [];

        /** @var OrderItem $item */
        foreach ($items as $key => $item){
            $digipeykItems[$key]['price'] = $item->getPrice();
            $digipeykItems[$key]['itemType'] = "peik";
            $digipeykItems[$key]['itemIdentifier'] = "34546uh5g45";
            $digipeykItems[$key]['sender'] = $item->getItemSource()->toDigipeykArray();
            $digipeykItems[$key]['receiver'] = $item->getItemDestination()->toDigipeykArray();
            $digipeykItems[$key]['priceDetails'] = $this->getPrice()->toDigipeykArray();
        }

        $options = $this->getOptions();

        $options['payment'] = [
            'place' => $this->getPayment()->getPlace(),
            'type'  => $this->getPayment()->getType()
        ];


       return [
            'options' => $options,
            'items'   => $digipeykItems
       ];

    }


}
