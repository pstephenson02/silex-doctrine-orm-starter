<?php

namespace tests\integration\App\Controller;

use Symfony\Component\HttpFoundation\Response;
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
        $this->assertCount(2, json_decode($client->getResponse()->getContent()));
    }

    public function testGetUser()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $client->request('GET', '/user/1');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertNotEmpty($client->getResponse()->getContent());
    }

    public function testCreateUser()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $client->request(
            'POST',
            '/user/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['email' => 'michaelbluth@arresteddevelopment.com'])
        );
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertNotNull($client->getResponse()->getContent());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateUser()
    {
        $updatedUser = ['email' => 'georgemichael@arrestedevelopment.com'];
        $client = $this->createClient();
        $client->followRedirects(true);
        $client->request(
            'PUT',
            '/user/2',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($updatedUser)
        );
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertNotEmpty($client->getResponse()->getContent());
        $responseArray = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('email', $responseArray);
        $this->assertEquals($updatedUser['email'], $updatedUser['email']);
    }

    public function testDeleteUser()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $client->request('DELETE', '/user/2');
        $this->assertTrue($client->getResponse()->isEmpty());
        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
