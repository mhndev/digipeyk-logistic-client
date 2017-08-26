<?php
namespace mhndev\digipeykLogisticClient\valueObjects;

use mhndev\valueObjects\interfaces\iValueObject;

/**
 * Class OrderEvent
 * @package mhndev\digipeykLogisticClient\valueObjects
 */
class OrderEvent implements iValueObject
{

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
    public function getDate(): \DateTime
    {
        return $this->date;
    }


    /**
     * @param array $options
     * @return static
     */
    function fromOptions(array $options)
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


}
