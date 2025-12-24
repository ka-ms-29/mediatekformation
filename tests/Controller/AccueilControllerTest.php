<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * AccueilControllerTest : class pour tester la controller d'accueil
 *
 * @author Mostaghfera Jan
 */
class AccueilControllerTest extends WebTestCase{
    /**
     * teste d'acces la page d'accueil
     */
    public function testAccesPage(){
        $client = static::createClient();
        $client->request('GET', '/'); 

        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
    /**
     * test de la link formations de la page accueil
     */
    public function testLinkFormations(){
       $client = static::createClient();
       $crawler = $client->request('GET', '/');
       $client->clickLink('Formations');
       $url = $client->getRequest()->getRequestUri();
       $this->assertResponseIsSuccessful();
       $this->assertEquals('/formations', $url);
    }
    /**
     * test de la link playlists de la page accueil
     */
    public function testLinkPlaylists(){
       $client = static::createClient();
       $crawler = $client->request('GET', '/');
       $client->clickLink('Playlists');
       $url = $client->getRequest()->getRequestUri();
       $this->assertResponseIsSuccessful();
       $this->assertEquals('/playlists', $url);
    }
}
