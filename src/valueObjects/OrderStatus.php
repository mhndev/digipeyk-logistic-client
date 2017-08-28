<?php
namespace mhndev\digipeykLogisticClient\valueObjects;

use mhndev\valueObjects\interfaces\iValueObject;

/**
 * Class OrderStatus
 * @package mhndev\digipeykLogisticClient\valueObjects
 */
class OrderStatus implements iValueObject
{

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $preview;


    const possible_statuses = [
        'init'              => ['code' => 'init'     , 'description' => '{{status_order_init}}'],
        'assigned'          => ['code' => 'assigned' , 'description' => '{{status_order_assigned}}'],
        'accepted'          => ['code' => 'accepted' , 'description' => '{{status_order_accepted}}'],
        'pickedup'          => ['code' => 'pickedup' , 'description' => '{{status_order_pickedup}}'],
        'delivered'         => ['code' => 'delivered', 'description' => '{{status_order_delivered}}'],
        'return'            => ['code' => 'return'   , 'description' => '{{status_order_return}}'],
        'ended'             => ['code' => 'ended', 'description' => '{{status_order_ended}}'],
        'canceled_customer' => ['code' => 'canceled_customer', 'description' => '{{status_order_canceled_by_customer}}'],
        'canceled_driver'   => ['code' => 'canceled_driver', 'description' => '{{status_order_canceled_by_driver}}'],
//        'rejected_driver'   => [],
        'deleted'           => ['code' => 'deleted', 'description' => '{{status_order_deleted}}']
    ];

    const INIT = 'init';
    const ASSIGNED = 'assigned';
    const ACCEPTED = 'accepted';
    const PICKEDUP = 'pickedup';
    const DELIVERED = 'delivered';
    const RETURN = 'return';
    const ENDED = 'ended';
    const CANCELED_CUSTOMER = 'canceled_customer';
    const CANCELED_DRIVER   = 'canceled_driver';
    const DELETED = 'deleted';

    public function __construct($code)
    {
        $this->code = $code;

        if (array_key_exists($code, self::possible_statuses)){
            $this->preview = self::possible_statuses[$code]['description'];
        }
    }

    /**
     * @param iValueObject $valueObject
     * @return boolean
     */
    function isEqual(iValueObject $valueObject)
    {
        /** @var OrderStatus $givenOrderStatus */
        $givenOrderStatus = $valueObject;

        return ($this->code == $givenOrderStatus->getCode());
    }

    /**
     * @return string
     */
    function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    function getPreview()
    {
        return $this->preview;
    }


    /**
     * @return array
     */
    function toArray()
    {
        return [
            'code' => $this->getCode(),
            'preview' => $this->getPreview()
        ];
    }


}
