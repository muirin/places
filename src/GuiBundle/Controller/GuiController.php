<?php
namespace GuiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation;

class GuiController extends Controller {

    /**
     * @Route("/gui")
     * @return HttpFoundation\Response
     */
    public function indexAction() {
        return $this->render(
            'GuiBundle:Gui:index.html.twig', [
                'center' => [
                    'lat' => $this->getParameter('api_place_default')['latitude'],
                    'lng' => $this->getParameter('api_place_default')['longitude']
                ]
            ]
        );
    }

    /**
     * @Route("/gui/places")
     * @return HttpFoundation\Response
     */
    public function getPlacesAction(HttpFoundation\Request $request) {
        if ($request->isXMLHttpRequest()) {
            $params = [
                'lat' => $request->request->get('lat'),
                'lng' => $request->request->get('lng'),
            ];
            try {
                $sender = $this->get('sender');
                $response = $sender->sendGetRequest($this->getParameter('api_gui')['url'] . $this->getParameter('api_gui')['place_type'], $params, ['Accept' => 'application/json']);
            } catch (\Exception $e) {
                return new HttpFoundation\JsonResponse('Error while getting places from API: '. $e->getMessage(), 500);
            }
            return new HttpFoundation\JsonResponse($response);
        }
        return new HttpFoundation\JsonResponse('Wrong request. Only AJAX requests allowed.', 400);
    }

}
