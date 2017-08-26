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


    const TYPE_WALLET = 'wallet';

    const TYPE_CASH   = 'cash';

    const TYPE_ONLINE = 'online';

    const TYPE_CUSTOM = 'custom';


    /**
     * OrderPayment constructor.
     * @param int $amount
     * @param int $transaction_id
     * @param string $type
     */
    public function __construct(int $amount, int $transaction_id, string $type = 'wallet')
    {
        $this->amount = $amount;
        $this->transaction_id = $transaction_id;
        $this->type = $type;
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
            'transaction_id' => $this->getTransactionId()
        ];
    }


    /**
     * @param array $options
     * @return static
     */
    function fromOptions(array $options)
    {
        return new static($options['amount'], $options['transaction_id'], $options['type']);
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
}
