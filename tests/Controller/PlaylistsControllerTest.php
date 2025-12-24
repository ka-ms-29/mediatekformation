<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of PlaylistsControllerTest
 *
 * @author Mostaghfera Jan
 */
class PlaylistsControllerTest extends WebTestCase{
    /**
     * constante pour enregistrer la valeur de selector
     */
    const FIRSTROW = 'table tbody tr:first-child td:first-child h5.text-info';
    /**
     * test tri des playlist sur nom et ASC
     */
    public function testtriPlaylist(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/tri/name/ASC');
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('Bases de la programmation (C#)', $firstRowTitle);
    }
    /**
     * test filtre des playlists 
     */
    public function testFiltrePlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists');		
        $crawler = $client->submitForm('filtrer', ['recherche' => 'java']);		
        $this->assertCount(2, $crawler->filter('table tbody tr'));
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertSelectorTextContains('h5.text-info', $firstRowTitle);
    }
    
    /**
     * test la link de btn "Voir Detail"
     */
    public function testButtonVoirDetail(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists');
        $button = $crawler->selectLink('Voir détail')->link();
        $crawler = $client->click($button);
        $uri = $client->getRequest()->getRequestUri();
        $this->assertEquals('/playlists/playlist/13',$uri);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h4');
        $this->assertSelectorTextContains('h4','Bases de la programmation (C#)');
    }
    

    
}
