<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class ApiController extends FOSRestController {

    public function optionsPizzaAction() {
        
    }

    public function getKetchupAction() {

        $data = [
            'type' => 'Spicy',
            'quantity' => '30ml',
        ];
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }

}
