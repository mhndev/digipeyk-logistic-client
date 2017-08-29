<?php
namespace mhndev\digipeykLogisticClient\valueObjects;

use mhndev\valueObjects\interfaces\iValueObject;

/**
 * Class OrderPayment
 * @package mhndev\digipeykLogisticClient\valueObjects
 */
class OrderPayment implements iValueObject
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var integer
     */
    protected $amount;

    /**
     * @var mixed
     */
    protected $transaction_id;

    /**
     * @var string
     */
    protected $place;


    const TYPE_WALLET       = 'wallet';

    const TYPE_CASH         = 'cash';

    const TYPE_ONLINE       = 'online';

    const TYPE_CUSTOM       = 'custom';

    const PLACE_ORIGIN      = 'origin';

    const PLACE_DESTINATION = 'destination';


    /**
     * OrderPayment constructor.
     * @param int $amount
     * @param int $transaction_id
     * @param string $place
     * @param string $type
     */
    public function __construct(int $amount, int $transaction_id = null, string $place ,string $type = 'wallet')
    {
        $this->amount = $amount;
        $this->transaction_id = $transaction_id;
        $this->type = $type;
        $this->place = $place;
    }



    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }


    /**
     * @return array
     */
    function toArray()
    {
        return [
            'type' => $this->getType(),
            'amount' => $this->getAmount(),
            'transaction_id' => $this->getTransactionId(),
            'place' => $this->getPlace()
        ];
    }

    function preview()
    {
        return $this->toArray();
    }


    /**
     * @param array $options
     * @return static
     */
    static function fromOptions(array $options)
    {
        $transactionId = !empty($options['transaction_id']) ? $options['transaction_id'] : null;

        return new static($options['amount'], $transactionId, $options['place'] ,$options['type']);
    }


    /**
     * @param array $options
     * @return OrderPayment
     */
    function fromArray(array $options)
    {
        return self::fromOptions($options);
    }


    /**
     * @param iValueObject $valueObject
     * @return boolean
     */
    function isEqual(iValueObject $valueObject)
    {
        /** @var OrderPayment $orderPayment */
        $orderPayment = $valueObject;

        return
            ( $this->getType() == $orderPayment->getType() ) &&
            ( $this->getAmount() == $orderPayment->getAmount() ) &&
            ( $this->getTransactionId() == $orderPayment->getTransactionId() );
    }

    /**
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace(string $place)
    {
        $this->place = $place;
    }

    /**
     * @param mixed $transaction_id
     */
    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }
}
