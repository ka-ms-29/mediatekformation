<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author Mostaghfera Jan
 */
class PlaylistRepositoryTest extends KernelTestCase{
    /**
     * 
     * @return PlaylistRepository
     */
    public function recupRepository() : PlaylistRepository{
        self::bootKernel();
        $repository= self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
    
    /**
     * initialisation de playlist
     * @return Playlist
     */
    public function newPlaylist(): Playlist {
        
        return (new Playlist())
            ->setName("test");                
    }
    
    /**
     * test le nombre des playlists
     */
    public function testNbPlaylist(){
        $repository = $this->recupRepository();
        $nbPlaylist = $repository->count([]);
        $this->assertEquals(29 , $nbPlaylist);
    }
    
    /**
     * test la methode AddPlaylist PlaylistRepository
     */
    public function testAddPlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylist = $repository->count([]);
        $repository->add($playlist, true);
        $this->assertEquals($nbPlaylist + 1, $repository->count([]), "erreur teste");
    }
    
    /**
     * test la methode RemovePlaylist PlaylistRepository
     */
    public function testRemovePlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist);
        $nbPlaylist = $repository->count([]);
        $repository->remove($playlist);
        $this->assertEquals($nbPlaylist - 1, $repository->count([]), "erreur test remove ");
    }
    
    /**
     * test la methode findAllOrderByName PlaylistRepository
     */
    public function testfindAllOrderByName(){
        
        $repository = $this->recupRepository();
        $results = $repository->findAllOrderByName('ASC');
        $this->assertLessThanOrEqual(0, strcasecmp(
            $results[0]->getName(),
            $results[1]->getName()
            )
        );
    }
    
    /**
     * test la methode findByContainValue PlaylistRepository
     */
    public function testfindByContainValue(){
        $repository = $this->recupRepository();
        $playlists = $repository->findByContainValue("name", "cours",);
        $nbplaylists = count($playlists);
        $this->assertEquals(11, $nbplaylists);
        
    }
}
