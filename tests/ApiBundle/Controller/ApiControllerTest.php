<?php
namespace Tests\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase {

    public function testGetPlacesSuccess() {
        $client = static::createClient();

        $crawler = $client->request(
                'GET', '/api/place/restaurant?lat=50.0851787&lng=19.850629900000058&radius=1000', array(), array(), ['HTTP_Accept' => 'application/json']);


        $this->assertTrue(
                $client->getResponse()->headers->contains(
                        'Content-Type', 'application/json'
                )
        );

        $this->assertEquals(
                200, $client->getResponse()->getStatusCode()
        );

        $jsonResponse = $client->getResponse()->getContent();
        $arrayResponse = json_decode($jsonResponse);

        $this->assertGreaterThanOrEqual(0, count($arrayResponse));
    }

    public function testGetPlacesFail() {
        $client = static::createClient();

        $crawler = $client->request(
                'GET', '/api/place/rest?lat=50.0851787&lng=19.850629900000058&radius=1000', array(), array(), ['HTTP_Accept' => 'application/json']);


        $this->assertTrue(
                $client->getResponse()->headers->contains(
                        'Content-Type', 'application/json'
                )
        );

        $this->assertEquals(
                400, $client->getResponse()->getStatusCode()
        );
    }

}
