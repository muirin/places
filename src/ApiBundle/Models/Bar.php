<?php
namespace ApiBundle\Models;

/**
 * Bar place model
 */
class Bar extends Place {
    
    public function __construct() {
        $this->type = self::TYPE_BAR;
    }
}