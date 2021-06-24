<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogPostControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/blog/post/'
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->isJson();
        $this->assertJsonStringEqualsJsonString('[{"id":3,"title":"Titre 1 pour test","publishedAt":"2018-09-23T14:00:00+00:00","blogComments":[]},{"id":4,"title":"Titre 2 pour test","publishedAt":"2019-09-23T14:00:00+00:00","blogComments":[]}]', $client->getResponse()->getContent());
    }

    public function testShow(): void
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/blog/post/3'
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->isJson();
        $this->assertJsonStringEqualsJsonString('{"id":3,"title":"Titre 1 pour test","publishedAt":"2018-09-23T14:00:00+00:00","blogComments":[]}', $client->getResponse()->getContent());
    }
}
