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
            ['/ca/blog/noticies'],
            ['/es/blog/noticias'],
            ['/en/blog/news'],
            ['/ca/blog/etiqueta/art'],
            ['/es/blog/etiqueta/arte'],
            ['/en/blog/tag/art'],
            ['/ca/entrades'],
            ['/es/entradas'],
            ['/en/tickets'],
            ['/ca/contacte'],
            ['/es/contacto'],
            ['/en/contact'],
            ['/ca/politica-de-privacitat'],
            ['/es/politica-de-privacidad'],
            ['/en/privacy-policy'],
            ['/ca/avis-legal'],
            ['/es/aviso-legal'],
            ['/en/legal-warning'],
            ['/ca/qui-som'],
            ['/es/quienes-somos'],
            ['/en/who-we-are'],
            ['/ca/patrocinadors'],
            ['/es/patrocinadores'],
            ['/en/partners'],
            ['/ca/participants'],
            ['/es/participantes'],
            ['/en/participants'],
            ['/ca/participant/name-surname'],
            ['/es/participante/name-surname'],
            ['/en/participant/name-surname'],
            ['/ca/ubicacions'],
            ['/es/ubicaciones'],
            ['/en/locations'],
            ['/ca/ubicacio/museu'],
            ['/es/ubicacion/museu'],
            ['/en/location/museu'],
            ['/ca/activitats'],
            ['/es/actividades'],
            ['/en/activities'],
            ['/ca/conferencies'],
            ['/es/conferencias'],
            ['/en/conferences'],
            ['/ca/conferencies/activitat/activitat-1'],
            ['/es/conferencias/actividad/actividad-1'],
            ['/en/conferences/activity/activity-1'],
            ['/sitemap.default.xml'],
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
