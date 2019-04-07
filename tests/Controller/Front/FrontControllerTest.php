<?php

namespace App\Tests\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class FrontControllerTest
 */
class FrontControllerTest extends WebTestCase
{
    /**
     * @param string $url
     *
     * @dataProvider provideSuccessfulUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @return array
     */
    public function provideSuccessfulUrls()
    {
        return [
            ['/ca/'],
            ['/es/'],
            ['/en/'],
            ['/ca/blog'],
            ['/es/blog'],
            ['/en/blog'],
            ['/ca/entrades'],
            ['/es/entradas'],
            ['/en/tickets'],
        ];
    }

    /**
     * @param string $url
     *
     * @dataProvider provideNotFoundUrls
     */
    public function testPageIsNotFound($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isNotFound());
    }

    /**
     * @return array
     */
    public function provideNotFoundUrls()
    {
        return [
            ['/ac/'],
            ['/ca/bloc'],
//            ['/ca/tickets'],
        ];
    }
}
