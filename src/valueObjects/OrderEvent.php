<?php
namespace mhndev\digipeykLogisticClient\valueObjects;

use mhndev\valueObjects\interfaces\iValueObject;

/**
 * Class OrderEvent
 * @package mhndev\digipeykLogisticClient\valueObjects
 */
class OrderEvent implements iValueObject
{

    const EVENT_CANCEL_CUSTOMER = 'cancel_customer';

    const EVENT_ORDER_ASSIGNED  = 'order_assigned';

    const EVENT_ORDER_PICKED_UP = 'order_pick_up';

    const EVENT_ORDER_DELIVERED = 'order_delivered';

    const EVENT_ORDER_ENDED     = 'order_ended';


    /**
     * @var string
     */
    protected $name;

    /**
     * @var \DateTime
     */
    protected $date;


    /**
     * OrderEvent constructor.
     * @param $name
     * @param \DateTime $date
     */
    public function __construct($name, \DateTime $date = null)
    {
        $this->name = $name;

        $this->date = empty($date) ? new \DateTime() : $date;
    }


    /**
     * @param iValueObject $valueObject
     * @return boolean
     */
    function isEqual(iValueObject $valueObject)
    {
        /** @var OrderEvent $orderEvent */
        $orderEvent = $valueObject;

        return
            ($orderEvent->getName() == $this->getName()) &&
            ($orderEvent->getDate() == $this->getDate() );
    }



    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * @param array $options
     * @return static
     */
    static function fromOptions(array $options)
    {

        $date = empty($options['date']) ? null : $options['date'];

        return new static($options['name'], $date);
    }

    /**
     * @param array $options
     * @return OrderEvent
     */
    function fromArray(array $options)
    {
        return self::fromOptions($options);
    }

    /**
     * @return array
     */
    function toArray()
    {
        return [
            'name' => $this->getName(),
            'date' => $this->getDate()
        ];
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function preview()
    {
        return [
            'name' => $this->getName(),
            'date' => $this->getDate()
        ];
    }



    /**
     * @param $array
     * @return array
     */
    public static function arrayPreview($array)
    {
        $result = [];

        foreach ($array as $key => $element){
            if ($element instanceof self){
                $result[$key] = $element->preview();
            }
        }
        return $result;
    }


}
