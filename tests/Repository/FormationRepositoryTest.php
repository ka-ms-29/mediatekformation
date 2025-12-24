<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use App\Repository\FormationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationRepositoryTest
 *
 * @author Mostaghfera Jan
 */
class FormationRepositoryTest extends KernelTestCase{
    /**
     * 
     * @return FormationRepository
     */
    public function recupRepository() : FormationRepository{
        self::bootKernel();
        $repository= self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    /**
     * initialisation d'un formation
     * @return Formation
     */
    public function newFormation(): Formation {
        
        return (new Formation())
            ->setTitle("s")
            ->setVideoId("1234")
            ->setPublishedAt(new DateTime('today'));
          
    }
    
    /**
     * test la methode de AddFormation de FormationReposotory
     */
    public function testAddFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $nbFormation = $repository->count([]);
        $repository->add($formation, true);
        $this->assertEquals($nbFormation + 1, $repository->count([]), "erreur teste");
    }
    
    /**
     * test nombres des formations
     */
    public function testNbFormation(){
        $repository = $this->recupRepository();
        $nbFormation = $repository->count([]);
        $this->assertEquals(251 , $nbFormation);
    }
    
    /**
     * test la methode de RemoveFormation de FormationReposotory
     */
    public function testRemoveFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation);
        $nbFormation = $repository->count([]);
        $repository->remove($formation);
        $this->assertEquals($nbFormation - 1, $repository->count([]), "erreur test remove ");
    }
    
    /**
     * test la methode de OrderByTitle de FormationReposotory
     * @return void
     */
    public function testOrderByTitle(): void{
        $repository = $this->recupRepository();
        $results = $repository->findAllOrderBy('title', 'ASC');
        $this->assertLessThanOrEqual(0, strcasecmp(
            $results[0]->getTitle(),
            $results[1]->getTitle()
            )
        );
    } 
    
    /**
     * test la methode de findByContainValue de FormationReposotory
     */
    public function testfindByContainValue(){
        $repository = $this->recupRepository();
        $formations = $repository->findByContainValue("title", "UML",);
        $nbformations = count($formations);
        $this->assertEquals(10, $nbformations);
        
    }
    
    /**
     * test la methode de findAllForOnePlaylist de FormationReposotory
     */
    public function testfindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $idPlaylist = 1;
        $formations = $repository->findAllForOnePlaylist($idPlaylist);
        $nbformations = count($formations);
        $this->assertEquals(8, $nbformations);
        
    }
    
    /**
     * test la methode de findAllForOneCategorie de FormationReposotory
     */
    public function testfindAllForOneCategorie(){
        $repository = $this->recupRepository();
        $categorie_id = 1;
        $formations = $repository->findAllForOneCategorie($categorie_id);
        $nbformations = count($formations);
        $this->assertEquals(15, $nbformations);
        
    }
}
