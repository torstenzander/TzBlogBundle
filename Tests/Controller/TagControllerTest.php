<?php

namespace Tz\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TagControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/blog/tags/new');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'tz_blogbundle_tagtype[text]'  => 'Test',
            'tz_blogbundle_tagtype[slug]'  => 'test',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();


    }

}