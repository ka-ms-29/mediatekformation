<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of AdminFormationsControllerTest
 *
 * @author Mostaghfera Jan
 */
class AdminFormationsControllerTest extends WebTestCase{
    
    /**
     * constante pour enregistrer la valeur de selector
     */
    const FIRSTROW = 'table tbody tr:first-child td:first-child h5.text-info';
    /**
     * test tri des playlist sur nom et ASC
     */   
    private function loginAsAdmin($client)
    {
        $admin = static::getContainer()
            ->get(UserRepository::class)
            ->findOneBy(['username' => 'admin']);
        $client->loginUser($admin);
    }
    /**
     * teste la tri des formation par nom
     */
    public function testTriFormationNom(){        
        $client = static::createClient();
        $this->loginAsAdmin($client);
        $crawler = $client->request('GET', '/admin/formations/tri/title/ASC');
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('Android Studio (complément n°1) : Navigation Drawer et Fragment', $firstRowTitle);
    }
    /**
     * teste la tri des formation par playlist
     */
    public function testtriFormationPlaylist(){
        $client = static::createClient();
        $this->loginAsAdmin($client);
        $crawler = $client->request('GET', '/admin/formations/tri/name/ASC/playlist');
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('Bases de la programmation n°74 - POO : collections', $firstRowTitle);
    }
    /**
     * teste la tri des formation par date_published
     */
    public function testTriFormationDate(){       
        $client = static::createClient();
        $this->loginAsAdmin($client);        
        $crawler = $client->request('GET', '/admin/formations/tri/publishedAt/ASC');
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals("Cours UML (1 à 7 / 33) : introduction et cas d'utilisation", $firstRowTitle);
    }
    /**
     * teste filtre des formation par nom
     */
    public function testFiltreFormation(){
        $client = static::createClient();
        $this->loginAsAdmin($client);               
        $client->request('GET', '/admin');		
        $crawler = $client->submitForm('filtrer', ['recherche' => 'java']);		
        $this->assertCount(7, $crawler->filter('table tbody tr')); 
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('TP Android n°5 : code du controleur et JavaDoc', $firstRowTitle);
    }
    /**
     * teste filtre des formation par playlist
     */
    public function testFiltrePlaylist(){
        $client = static::createClient();
        $this->loginAsAdmin($client);
        $client->request('GET', '/admin');		
        $crawler = $client->submitForm('Filtrer', ['recherche' => 'java']);		
        $this->assertCount(14, $crawler->filter('table tbody tr'));
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('Eclipse n°7 : Tests unitaires', $firstRowTitle);
    }
    /**
     * test bouton Modifier de la page /admin
     */
    public function testButtonModifier(){
        $client = static::createClient();
        //faire login comme admin
        $this->loginAsAdmin($client);
        $crawler = $client->request('GET', '/admin');
        $button = $crawler->selectLink('Modifier')->link();
        $crawler = $client->click($button);
        $uri = $client->getRequest()->getRequestUri();
        $this->assertEquals('/admin/edit/3',$uri);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h2');
        $this->assertSelectorTextContains("h2","Modification d'une formation");
    }
    /**
     * test bouton Ajouter de la page /admin
     */
    public function testButtonAjouter(){
        $client = static::createClient();
        //faire login comme admin
        $this->loginAsAdmin($client);
        $crawler = $client->request('GET', '/admin');
        $button = $crawler->selectLink('Ajouter')->link();
        $crawler = $client->click($button);
        $uri = $client->getRequest()->getRequestUri();
        $this->assertEquals('/admin/ajout',$uri);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h2');
        $this->assertSelectorTextContains("h2","Ajouter une nouvelle formation :");
    }
    
}
