<?php
namespace mhndev\digipeykLogisticClient\valueObjects;

use mhndev\valueObjects\implementations\Address;
use mhndev\valueObjects\implementations\HomePhoneTehran;
use mhndev\valueObjects\implementations\MobilePhone;
use mhndev\valueObjects\interfaces\iValueObject;

/**
 * Class OrderItemSource
 * @package mhndev\digipeykLogisticClient\valueObjects
 */
class OrderItemSource implements iValueObject
{

    /**
     * @var HomePhoneTehran
     */
    protected $phone;

    /**
     * @var MobilePhone
     */
    protected $mobile;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $organization;

    /**
     * @var string
     */
    protected $description;


    /**
     * @param iValueObject $valueObject
     * @return boolean
     */
    function isEqual(iValueObject $valueObject)
    {
        /** @var OrderItemSource $givenOrderItemSource */
        $givenOrderItemSource = $valueObject;

        return
            ( $this->getName() == $givenOrderItemSource->getName() ) &&
            ( $this->getMobile()->isEqual($givenOrderItemSource->getMobile() ) ) &&
            ( $this->getPhone()->isEqual($givenOrderItemSource->getPhone() ) ) &&
            ( $this->getAddress()->isEqual($givenOrderItemSource->getAddress() ) ) &&
            ( $this->getOrganization() == $givenOrderItemSource->getOrganization() ) &&
            ( $this->getDescription() == $givenOrderItemSource->getDescription() );

    }


    /**
     * @return HomePhoneTehran
     */
    public function getPhone(): HomePhoneTehran
    {
        return $this->phone;
    }

    /**
     * @return MobilePhone
     */
    public function getMobile(): MobilePhone
    {
        return $this->mobile;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getOrganization(): string
    {
        return $this->organization;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    function toArray()
    {
        return [
            'name'         => $this->getName(),
            'phone'        => $this->getPhone()->toArray(),
            'mobile'       => $this->getMobile()->toArray(),
            'organization' => $this->getOrganization(),
            'description'  => $this->getDescription(),
            'address'      => $this->getAddress()->toArray()
        ];
    }

}