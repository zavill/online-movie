<?php


namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RatingControllerTest extends WebTestCase
{
    public function testPost()
    {
        $client = static::createClient();

        /* Запрос без указания значений */
        $client->request('POST', '/api/rating/', []);
        $this->assertEquals(422, $client->getResponse()->getStatusCode());

        /* Запрос без указания значения рейтинга */
        $client->request('POST', '/api/rating/', ['serialId' => 2]);
        $this->assertEquals(422, $client->getResponse()->getStatusCode());

        /* Запрос без указания значения ид сериала */
        $client->request('POST', '/api/rating/', ['rating' => 2]);
        $this->assertEquals(422, $client->getResponse()->getStatusCode());

        /* Запрос с заполненными полями */
        $client->request('POST', '/api/rating/', ['serialId' => 2, 'rating' => 5]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}