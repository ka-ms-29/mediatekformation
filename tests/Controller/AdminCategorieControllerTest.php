<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * AdminCategorieControllerTest : teste du controller AdminCategorieController, partie admin
 *
 * @author Mostaghfera Jan
 */
class AdminCategorieControllerTest extends WebTestCase{
 
    /**
     * constant
     */
    const FIRSTROW = 'table tbody tr:first-child td:first-child h5.text-info';

    /**
     * login en tant qu'admin
     * @param type $client
     */
    private function loginAsAdmin($client)
    {
        $admin = static::getContainer()
            ->get(UserRepository::class)
            ->findOneBy(['username' => 'admin']);
        $client->loginUser($admin);
    }
    
    /**
     * test l'acces du page categorie
     */
    public function testAccesPage(){
        $client = static::createClient();
        $this->loginAsAdmin($client);
        $client->request('GET', '/admin/categories');
        $this->assertResponseIsSuccessful();
    }
    
    /**
     * test la bouton Ajouter
     */
    public function testBoutonAjouter(){
        $client = static::createClient();
        //faire login comme admin
        $this->loginAsAdmin($client);
        $crawler = $client->request('GET', '/admin/categories');
        $form = $crawler->selectButton('Ajouter')->form([
            'name' => 'Nouvelle catégorie',
        ]);
        $client->submit($form);
        $this->assertResponseRedirects('/admin/categories');
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('h2', 'Gestion des catégories');
        $this->assertSelectorTextContains('table', 'Nouvelle catégorie');
    }
    
}
