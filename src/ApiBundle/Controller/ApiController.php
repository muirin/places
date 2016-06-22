<?php
namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Component\HttpFoundation;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use ApiBundle\Models;

/**
 * REST Places API controller
 */
class ApiController extends FOSRestController {

    /**
     * REST API providing information about places of selected type located within {radius}m radius 
     * around selected location {lat},{lng}. 
     * 
     * Provide radius, latitude and longitude in request.
     * Default values: location - Gdansk, Neptune's Fountain, radius - 2km.
     *
     * @ApiDoc(
     * resource=true,
     * statusCodes={
     *      200="Returned when successful",
     *      400="Returned in case of incorrect request parameter",
     *      500={
     *           "Returned when error occured",
     *           "Returned when external API returned error"
     *           "Returned in case of internal API error"
     *      }
     * },
     * parameters={
     *      {"name"="lat", "dataType"="float", "required"=false, "description"="Location latitude"},
     *      {"name"="lng", "dataType"="float", "required"=false, "description"="Location longitude"},
     *      {"name"="radius", "dataType"="integer", "required"=false, "description"="Radius around location, in meters"}
     * }
     * )
     * 
     * @Configuration\Route("/place/{type}")
     * @Configuration\Method({"GET"})
     * @param HttpFoundation\Request Request to our api
     * @param string $type Requested location type. Available values: bar, restaurant.
     * @return HttpFoundation\Response
     */
    public function getPlacesAction(HttpFoundation\Request $request, $type) {
        if (!$this->validateType($type)) {
            return new HttpFoundation\JsonResponse('Incorrect place type:'. $type, 400);
        }

        try {
            $requestParameters = $this->prepareRequestParameters($request, $type);
            $sender = $this->get('sender');
            $response = $sender->sendGetRequest($this->getParameter('api_google_maps')['url'] . $this->getParameter('api_google_maps')['format'], $requestParameters);
            $responseParser = $this->get('search_response_parser');
            $places = $responseParser->prepareResponse($response, $type);
        } catch (\Exception $e) {
            return new HttpFoundation\JsonResponse('Error while searching for places: '. $e->getMessage(), 500);
        }

        $view = $this->view($places, 200);
        return $this->handleView($view);
    }

    /**
     * Prepare request to google places API
     * @param HttpFoundation\Request $request Request to our api
     * @param string $type Requested location type. Available values: bar, restaurant.
     * @return array $requestParameters
     */
    private function prepareRequestParameters(HttpFoundation\Request $request, $type) {
        $latitude = (null !== $request->query->get('lat')) ? $request->query->get('lat') : $this->getParameter('api_place_default')['latitude'];
        $longitude = (null !== $request->query->get('lng')) ? $request->query->get('lng') : $this->getParameter('api_place_default')['longitude'];
        $radius = (null !== $request->query->get('radius')) ? $request->query->get('radius') : $this->getParameter('api_place_default')['radius'];

        $requestParameters = [
            'location' => $latitude . ',' . $longitude,
            'radius' => $radius,
            'type' => $type,
            'key' => $this->getParameter('api_google_maps')['key'],
        ];
        return $requestParameters;
    }

    /**
     * Validate place type
     * @param string $type Requested location type
     * @return boolean true if type is correct
     */
    private function validateType($type) {
        if (!in_array($type, [Models\Place::TYPE_BAR, Models\Place::TYPE_RESTAURANT])) {
            return false;
        }
        return true;
    }

}
