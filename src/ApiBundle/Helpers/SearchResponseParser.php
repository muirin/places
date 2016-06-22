<?php
namespace ApiBundle\Helpers;

use ApiBundle\Models;

/**
 * Class for processing google place search response
 */
class SearchResponseParser {
    
    /**
     * Factory for creating place object of given type
     * @var PlaceFactoryInterface 
     */
    private $placeFactory;
    
    public function __construct(PlaceFactoryInterface $placeFactory){
        $this->placeFactory = $placeFactory;
    }

    /**
     * Process Google API search response. 
     * Prepare our API response.
     * @param array $response Google API response
     * @param string $type Place type
     * @return array API response array
     */
    public function prepareResponse($response, $type) {
        $places = [];
        foreach ($response['results'] as $result) {
            $place = $this->placeFactory->create($type);
            $coordinates = new Models\Coordinates();
            $coordinates->setLatitude($result['geometry']["location"]["lat"])
                    ->setLongitude($result['geometry']["location"]["lng"]);
            $place->setCoordinates($coordinates)
                    ->setName($result['name'])
                    ->setAddress($result["vicinity"]);
            $places[] = $place;
        }
        return $places;
    }
    
}
