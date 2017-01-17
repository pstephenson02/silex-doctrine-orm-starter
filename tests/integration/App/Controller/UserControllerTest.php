<?php

namespace tests\integration\App\Controller;

use tests\integration\App\WebTestCase;

/**
 * Class UserControllerTest
 * @package tests\integration\App\Controller
 */
class UserControllerTest extends WebTestCase
{
    public function testGetUsers()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $client->request('GET', '/user');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertNotEmpty($client->getResponse()->getContent());
    }
}
