<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of LoginControllerTest
 *
 * @author Mostaghfera Jan
 */
class LoginControllerTest extends WebTestCase{
    /**
     * test acces la page login 
     */
    public function testLoginPageLoads()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h3', 'Authentifiez-vous');
    }
    /**
     * test login avec identifiant incorrecte
     */
    public function testLoginFailed(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('se connecter')->form([
            '_username' => 'wronguser',
            '_password' => 'wrongpassword',
        ]);
        $client->submit($form);
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorTextContains('body', 'Invalid credentials');
    }
    
    /**
     * test login avec identifiant correcte
     */
    public function testSuccessfulLogin(){
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('se connecter')->form([
            '_username' => 'admin',
            '_password' => 'admin',
        ]);
        $client->submit($form);
        $this->assertResponseRedirects('/admin');
        $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Gestion de mediaTek86');   
    }
   
}
