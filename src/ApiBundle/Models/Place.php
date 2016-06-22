<?php
namespace ApiBundle\Models;

/**
 * Place model
 */
class Place {
    
    /**
     * BAR place type
     */
    const TYPE_BAR = 'bar';
    
    /**
     * RESTAURANT place type
     */
    const TYPE_RESTAURANT = 'restaurant';
    
    /**
     * Place type
     * @var string 
     */
    protected $type;
    
    /**
     * Place name
     * @var string
     */
    protected $name;
    
    /**
     * Place coordinates - latitude and longitude
     * @var Coordinates
     */
    protected $coordinates;
    
    /**
     * Place address
     * @var string
     */
    protected $address;
    
    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates() {
        return $this->coordinates;
    }

    /**
     * @param string $type
     * @return \ApiBundle\Models\Place
     */
    public function setType($type) {
        if(!in_array($type, [self::TYPE_BAR, self::TYPE_RESTAURANT])){
            throw new \RuntimeException('Incorrect place type');
        }
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $name
     * @return Place
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Coordinates $coordinates
     * @return Place
     */
    public function setCoordinates(Coordinates $coordinates) {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * @return type
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param type $address
     * @return \ApiBundle\Models\Place
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }


}
