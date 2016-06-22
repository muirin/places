<?php
namespace ApiBundle\Helpers;

use ApiBundle\Models;

interface PlaceFactoryInterface{
    
    /**
     * Create place of given type
     * @param string $type Place type
     * @return Models\Place
     */
    public function create($type);
}