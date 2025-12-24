<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of CategorieRepositoryTest
 *
 * @author Mostaghfera Jan
 */
class CategorieRepositoryTest extends KernelTestCase{
    
    /**
     * 
     * @return CategorieRepository
     */
    public function recupRepository() : CategorieRepository{
        self::bootKernel();
        $repository= self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    /**
     * initialisation de categorie
     * @return Categorie
     */
    public function newCategorie(): Categorie {
        
        return (new Categorie())
            ->setName("test");                
    }
    
    /**
     * test des nombres des categorie 
     */
    public function testNbCategorie(){
        $repository = $this->recupRepository();
        $nbCategorie = $repository->count([]);
        $this->assertEquals(11 , $nbCategorie);
    }
    /**
     * test la methode AddCategorie de CategorieRepository
     */
    public function testAddCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $nbCategorie = $repository->count([]);
        $repository->add($categorie, true);
        $this->assertEquals($nbCategorie + 1, $repository->count([]), "erreur teste");
    }
    /**
     * test la methode RemoveCategori de CategorieRepository
     */
    public function testRemoveCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie);
        $nbCategorie = $repository->count([]);
        $repository->remove($categorie);
        $this->assertEquals($nbCategorie - 1, $repository->count([]), "erreur test remove ");
    }
    /**
     * test la methode findAllForOnePlaylist de CategorieRepository
     */
    public function testfindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $idPlaylist = 1;
        $categories = $repository->findAllForOnePlaylist($idPlaylist);
        $nbcategories = count($categories);
        $this->assertEquals(2, $nbcategories);    
    }
    
}
