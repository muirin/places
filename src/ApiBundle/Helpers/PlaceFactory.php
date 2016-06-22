<?php
namespace ApiBundle\Helpers;

use ApiBundle\Models;

/**
 * Factory for creating place object of given type
 */
class PlaceFactory implements PlaceFactoryInterface{
    
    /**
     * Create place of given type
     * @param string $type Place type
     * @return Models\Place
     */
    public function create($type) {
        switch($type) {
            case Models\Place::TYPE_BAR:
                return new Models\Bar();
            case Models\Place::TYPE_RESTAURANT:
                return new Models\Restaurant();
        }
    }
}