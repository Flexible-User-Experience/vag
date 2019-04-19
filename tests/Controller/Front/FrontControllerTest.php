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
            ['/ca/noticies'],
            ['/es/noticias'],
            ['/en/news'],
            ['/ca/entrades'],
            ['/es/entradas'],
            ['/en/tickets'],
            ['/ca/contacte'],
            ['/es/contacto'],
            ['/en/contact'],
            ['/ca/equip'],
            ['/es/equipo'],
            ['/en/team'],
            ['/ca/participants'],
            ['/es/participantes'],
            ['/en/participants'],
            ['/ca/participant/name-surname'],
            ['/es/participante/name-surname'],
            ['/en/participant/name-surname'],
            ['/ca/ubicacions'],
            ['/es/ubicaciones'],
            ['/en/locations'],
            ['/ca/activitats'],
            ['/es/actividades'],
            ['/en/activities'],
            ['/ca/conferencies'],
            ['/es/conferencias'],
            ['/en/conferences'],
            ['/ca/conferencies/activitat/activitat-1'],
            ['/es/conferencias/actividad/actividad-1'],
            ['/en/conferences/activity/activity-1'],
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
            ['/ca/participant/missing-name-surname'],
        ];
    }
}
