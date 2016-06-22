<?php
namespace ApiBundle\Models;

/**
 * Restaurant place model
 */
class Restaurant extends Place {
    
    public function __construct() {
        $this->type = self::TYPE_RESTAURANT;
    }
}