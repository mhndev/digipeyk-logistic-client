<?php
namespace mhndev\digipeykLogisticClient\valueObjects;

use mhndev\valueObjects\interfaces\iValueObject;

/**
 * Class OrderPrice
 * @package mhndev\digipeykLogisticClient\valueObjects
 */
class OrderPrice implements iValueObject
{

    /**
     * @var integer
     */
    protected $forward_price = 0;

    /**
     * @var array of integer
     */
    protected $trips_price = [];

    /**
     * @var integer
     */
    protected $backward_price = 0;

    /**
     * @var integer
     */
    protected $insurance_price = 0;

    /**
     * @var integer
     */
    protected $total_price = 0;


    /**
     * OrderPrice constructor.
     * @param $forward
     * @param $backward
     * @param int $insurance
     */
    public function __construct($forward, $backward, $insurance = 0)
    {
        $this->addTripPrice($forward);
        $this->backward_price = $backward;
        $this->insurance_price = $insurance;
        $this->total_price = $this->forward_price + $this->backward_price + $this->insurance_price;
    }

    /**
     * @param integer $trip_price
     * @return $this
     */
    function addTripPrice($trip_price)
    {
        $this->trips_price[] = $trip_price;
        $this->forward_price += $trip_price;

        return $this;
    }

    /**
     * @param iValueObject $valueObject
     * @return boolean
     */
    function isEqual(iValueObject $valueObject)
    {
        /** @var OrderPrice $givenOrderPrice */
        $givenOrderPrice = $valueObject;

        return
            ( $this->forward_price == $givenOrderPrice->getForwardPrice() ) &&
            ( $this->backward_price == $givenOrderPrice->getBackwardPrice() ) &&
            ( $this->insurance_price == $givenOrderPrice->getInsurancePrice() );
    }

    /**
     * @return int
     */
    public function getForwardPrice()
    {
        return $this->forward_price;
    }

    /**
     * @return int
     */
    public function getInsurancePrice()
    {
        return $this->insurance_price;
    }

    /**
     * @return int
     */
    public function getTotalPrice() :int
    {
        return $this->total_price;
    }

    /**
     * @return int
     */
    public function getBackwardPrice(): int
    {
        return $this->backward_price;
    }


    /**
     * @return $this
     */
    function reset()
    {
        $this->forward_price = 0;
        $this->trips_price = [];
        $this->insurance_price = 0;
        $this->total_price = 0;
        $this->backward_price = 0;

        return $this;
    }


    /**
     * @return array
     */
    public function getTripsPrice(): array
    {
        return $this->trips_price;
    }

    /**
     * @return array
     */
    function toArray()
    {
        return [
            'forward'   => $this->getForwardPrice(),
            'backward'  => $this->getBackwardPrice(),
            'trips'     => $this->getTripsPrice(),
            'insurance' => $this->getInsurancePrice(),
            'total'     => $this->getTotalPrice(),
        ];
    }

    /**
     * @param array $options
     * @return static
     */
    public static function fromOptions($options)
    {
        return new static(
            $options['forward'],
            $options['backward'],
            $options['insurance']
        );
    }


}
