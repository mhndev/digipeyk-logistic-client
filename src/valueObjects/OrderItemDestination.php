<?php
namespace mhndev\digipeykLogisticClient\valueObjects;

use mhndev\valueObjects\implementations\Address;
use mhndev\valueObjects\implementations\HomePhoneTehran;
use mhndev\valueObjects\implementations\MobilePhone;
use mhndev\valueObjects\interfaces\iValueObject;

/**
 * Class OrderItemDestination
 * @package mhndev\digipeykLogisticClient\valueObjects
 */
class OrderItemDestination implements iValueObject
{

    /**
     * OrderItemSource constructor.
     * @param HomePhoneTehran|null $phone
     * @param MobilePhone|null $mobile
     * @param Address|null $address
     * @param string $name
     * @param string $organization
     * @param string $description
     */
    public function __construct(
        HomePhoneTehran $phone = null,
        MobilePhone $mobile = null,
        Address $address = null,
        string $name = '' ,
        string $organization = '',
        string $description = '')
    {
        $this->phone        = $phone;
        $this->mobile       = $mobile;
        $this->address      = $address;
        $this->name         = $name;
        $this->organization = $organization;
        $this->description  = $description;
    }


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
    public function isEqual(iValueObject $valueObject)
    {
        /** @var OrderItemDestination $givenOrderItemDestination */
        $givenOrderItemDestination = $valueObject;

        return
            ( $this->getName() == $givenOrderItemDestination->getName() ) &&
            ( $this->getMobile()->isEqual($givenOrderItemDestination->getMobile() ) ) &&
            ( $this->getPhone()->isEqual($givenOrderItemDestination->getPhone() ) ) &&
            ( $this->getAddress()->isEqual($givenOrderItemDestination->getAddress() ) ) &&
            ( $this->getOrganization() == $givenOrderItemDestination->getOrganization() ) &&
            ( $this->getDescription() == $givenOrderItemDestination->getDescription() );

    }


    /**
     * @return HomePhoneTehran
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return MobilePhone
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name'         => $this->getName(),
            'phone'        => !empty($this->getPhone()) ? $this->getPhone()->preview() : null,
            'mobile'       => !empty($this->getMobile()) ? $this->getMobile()->preview() : null,
            'organization' => $this->getOrganization(),
            'description'  => $this->getDescription(),
            'address'      => !empty($this->getAddress()) ? $this->getAddress()->toArray() : null
        ];
    }

    /**
     * @return array
     */
    public function preview()
    {
        return [
            'name'         => $this->getName(),
            'phone'        => !empty($this->getPhone()) ? $this->getPhone()->preview() : null,
            'mobile'       => !empty($this->getMobile()) ? $this->getMobile()->preview() : null,
            'organization' => $this->getOrganization(),
            'description'  => $this->getDescription(),
            'address'      => !empty($this->getAddress()) ? $this->getAddress()->preview() : null
        ];
    }



    /**
     * @param $array
     * @return static
     */
    public static function fromOptions($array)
    {
        if (!empty($array['phone']) && is_array($array['phone'])){
            $array['phone'] = $array['phone']['number'];
        }
        if (!empty($array['mobile']) && is_array($array['mobile'])){
            $array['mobile'] = $array['mobile']['number'];
        }

        return new static(
            HomePhoneTehran::fromOptions($array['phone']),
            MobilePhone::fromOptions($array['mobile']),
            Address::fromOptions($array['address']),
            $array['name'],
            $array['organization'],
            $array['description']
        );
    }


    /**
     * @return array
     */
    public function toDigipeykArray()
    {
        $result = $this->toArray();
        $mobile = $result['mobile'];
        $home = $result['phone'];
        unset($result['mobile'], $result['home']);
        $result['phone'] = [
            'mobile' => $mobile,
            'home'   => $home
        ];

        return $result;
    }


}
