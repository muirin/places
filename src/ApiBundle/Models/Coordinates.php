<?php
namespace ApiBundle\Models;

/**
 * Place coordinates model
 */
class Coordinates {
    
    /**
     * Place latitude
     * @var float 
     */
    private $latitude;
    
    /**
     * Place longitude
     * @var float 
     */
    private $longitude;

    /**
     * @return float
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * @param float $latitude
     * @return Coordinates
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }
    
    /**
     * @param float $longitude
     * @return Coordinates
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }


    
}
