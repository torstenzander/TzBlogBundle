<?php

namespace Tz\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{

    /**
     * @test
     */
    public function checkIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/blog/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }


}