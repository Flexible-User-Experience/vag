<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class FrontControllerTest
 */
class FrontControllerTest extends WebTestCase
{
    /**
     * Test homepage
     */
    public function testHomepage()
    {
        $client = static::createClient();
        $client->request('GET', '/ca/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
