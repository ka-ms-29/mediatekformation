<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of AdminPlaylistsControllerTest
 *
 * @author Mostaghfera Jan
 */
class AdminPlaylistsControllerTest extends WebTestCase{
    
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
     * 
     */
    public function testtriPlaylistParNom(){
        $client = static::createClient();
        //faire login comme admin
        $this->loginAsAdmin($client);
        $crawler = $client->request('GET', '/admin/playlists/tri/name/ASC');
        $this->assertResponseIsSuccessful();

        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('Bases de la programmation (C#)', $firstRowTitle);
    }
    /**
     * 
     */
    public function testtriPlaylistParNBformation(){
        $client = static::createClient();
        //faire login comme admin
        $this->loginAsAdmin($client);
        $crawler = $client->request('GET', '/admin/playlists/tri/formation/ASC');
        $this->assertResponseIsSuccessful();

        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('Cours Informatique embarquée', $firstRowTitle);
    }
    /**
     * 
     */
    public function testFiltrePlaylist(){
        $client = static::createClient();
        //faire login comme admin
        $this->loginAsAdmin($client);
        $client->request('GET', '/admin/playlists');		
        $crawler = $client->submitForm('filtrer', ['recherche' => 'java']);		
        $this->assertCount(2, $crawler->filter('table tbody tr'));
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('Eclipse et Java', $firstRowTitle);
    }
    /**
     * public function testFiltrePlaylistParCategorie(){
        $client = static::createClient();
        //faire login comme admin
        $this->loginAsAdmin($client);
        $crawler = $client->request('GET', '/admin/playlists');		
        $form = $crawler->filter('form.form-inline')->form();
        $form['recherche'] = 'UML';
        $crawler = $client->submit($form);		
        $this->assertCount(2, $crawler->filter('table tbody tr'));
        $firstRowTitle = $crawler->filter(self::FIRSTROW)->text();
        $this->assertEquals('Cours UML', $firstRowTitle);
    }
    
     */
    
    /**
     * 
     */
    public function testButtonModifier(){
        $client = static::createClient();
        //faire login comme admin
        $this->loginAsAdmin($client);
        $crawler = $client->request('GET', '/admin/playlists');
        $button = $crawler->selectLink('Modifier')->link();
        $crawler = $client->click($button);
        $uri = $client->getRequest()->getRequestUri();
        $this->assertEquals('/admin/playlist/edit/13',$uri);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h2');
        $this->assertSelectorTextContains('h2','Détail playlist');
    }
    /**
     * 
     */
    public function testButtonAjouter(){
        $client = static::createClient();
        //faire login comme admin
        $this->loginAsAdmin($client);
        $crawler = $client->request('GET', '/admin/playlists');
        $button = $crawler->selectLink('Ajouter')->link();
        $crawler = $client->click($button);
        $uri = $client->getRequest()->getRequestUri();
        $this->assertEquals('/admin/playlist/ajout',$uri);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h2');
        $this->assertSelectorTextContains("h2","Ajoute d'une nouvelle playlist :");
    }
    
    
}
