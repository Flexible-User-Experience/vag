<?php

namespace App\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AdminControllerTest
 */
class AdminControllerTest extends WebTestCase
{
    /**
     * @param string $url
     *
     * @dataProvider provideSuccessfulUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'test',
            'PHP_AUTH_PW'   => 'test',
        ]);
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @return array
     */
    public function provideSuccessfulUrls()
    {
        return [
            ['/ca/admin/dashboard'],
            ['/es/admin/dashboard'],
            ['/en/admin/dashboard'],
            ['/ca/admin/esdeveniment/categoria/list'],
            ['/es/admin/esdeveniment/categoria/list'],
            ['/en/admin/esdeveniment/categoria/list'],
            ['/ca/admin/esdeveniment/categoria/create'],
            ['/ca/admin/esdeveniment/categoria/1/edit'],
//            ['/ca/admin/esdeveniment/categoria/export'],
            ['/ca/admin/esdeveniment/ubicacio/list'],
            ['/es/admin/esdeveniment/ubicacio/list'],
            ['/en/admin/esdeveniment/ubicacio/list'],
            ['/ca/admin/esdeveniment/ubicacio/create'],
            ['/ca/admin/esdeveniment/ubicacio/1/edit'],
//            ['/ca/admin/esdeveniment/ubicacio/export'],
            ['/ca/admin/esdeveniment/col-laborador/list'],
            ['/es/admin/esdeveniment/col-laborador/list'],
            ['/en/admin/esdeveniment/col-laborador/list'],
            ['/ca/admin/esdeveniment/col-laborador/create'],
            ['/ca/admin/esdeveniment/col-laborador/1/edit'],
//            ['/ca/admin/esdeveniment/col-laborador/export'],
            ['/ca/admin/esdeveniment/activitat/list'],
            ['/es/admin/esdeveniment/activitat/list'],
            ['/en/admin/esdeveniment/activitat/list'],
            ['/ca/admin/esdeveniment/activitat/create'],
            ['/ca/admin/esdeveniment/activitat/1/edit'],
//            ['/ca/admin/esdeveniment/activitat/export'],
        ];
    }

    /**
     * @param string $url
     *
     * @dataProvider provideNotFoundUrls
     */
    public function testPageIsNotFound($url)
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'test',
            'PHP_AUTH_PW'   => 'test',
        ]);
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isNotFound());
    }

    /**
     * @return array
     */
    public function provideNotFoundUrls()
    {
        return [
            ['/ac/admin/dashboard'],
            ['/ac/admin/esdeveniment/categoria/list'],
            ['/ac/admin/esdeveniment/ubicacio/list'],
            ['/ac/admin/esdeveniment/col-laborador/list'],
            ['/ac/admin/esdeveniment/activitat/list'],
            ['/ca/admin/esdeveniment/categoria/1/show'],
            ['/ca/admin/esdeveniment/categoria/1/delete'],
            ['/ca/admin/esdeveniment/ubicacio/1/show'],
            ['/ca/admin/esdeveniment/ubicacio/1/delete'],
            ['/ca/admin/esdeveniment/col-laborador/1/show'],
            ['/ca/admin/esdeveniment/col-laborador/1/delete'],
            ['/ca/admin/esdeveniment/activitat/1/show'],
            ['/ca/admin/esdeveniment/activitat/1/delete'],
        ];
    }
}
