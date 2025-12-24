<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of FormationsControllerTest
 *
 * @author Mostaghfera Jan
 */
class FormationsControllerTest extends WebTestCase{
    
    /**
     * constant pour sauvegarder la valeur de la selector
     */
    const FIRSTROW = 'table tbody tr:first-child td:first-child h5.text-info';
    
    /**
     * test tri des formations sur le nom et Asc
     */
    public function testTriFormationNom(){        
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/title/ASC');
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('Android Studio (complément n°1) : Navigation Drawer et Fragment', $firstRowTitle);
    }
    
    /**
     * test tri des formations sur la playlist et Asc
     */
    public function testtriFormationPlaylist(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/name/ASC/playlist');
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('Bases de la programmation n°74 - POO : collections', $firstRowTitle);
    }
    
    /**
     * test tri des formations sur la date et Asc
     */
    public function testTriFormationDate(){       
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/publishedAt/ASC');
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals("Cours UML (1 à 7 / 33) : introduction et cas d'utilisation", $firstRowTitle);
    }
    
    /**
     * test filtre des formations
     */
    public function testFiltreFormation(){
        $client = static::createClient();
        $client->request('GET', '/formations');		
        $crawler = $client->submitForm('filtrer', ['recherche' => 'java']);		
        $this->assertCount(7, $crawler->filter('table tbody tr')); 
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertSelectorTextContains('h5.text-info', $firstRowTitle);
    }
    
    /**
     * test filtre des playlists
     */
    public function testFiltrePlaylist(){
        $client = static::createClient();
        $client->request('GET', '/formations');		
        $crawler = $client->submitForm('Filtrer', ['recherche' => 'java']);		
        $this->assertCount(14, $crawler->filter('table tbody tr'));
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertSelectorTextContains('h5.text-info', $firstRowTitle);
    }
}
