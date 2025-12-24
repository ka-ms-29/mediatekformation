<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Playlist;

use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * AdminPlaylistsController : controller des playlists patie admin
 *
 * @author Mostaghfera Jan
 */
class AdminPlaylistsController extends AbstractController{
    
    /**
     * 
     * @var PlaylistRepository
     */
    private $playlistRepository;
    
    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;    
    
    /**
     * constant pour enregistrer URL de la page playlistes
     */
    const PAGEPLAYLISTS = "admin/admin.playlists.html.twig";
    /**
     * constant pour enregistrer URL de la page playliste
     */
    const PAGEPLAYLIST = "admin/admin.playlist.html.twig";
    /**
     * constructeur de la class AdminPlaylistController
     * @param PlaylistRepository $playlistRepository
     * @param CategorieRepository $categorieRepository
     * @param FormationRepository $formationRespository
     */
    function __construct(PlaylistRepository $playlistRepository, 
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository) {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }
    
    /**
     * @Route("/playlists", name="playlists")
     * @return Response
     */
    #[Route('/admin/playlists', name: 'admin.playlists')]
    public function index(): Response{
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEPLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }

    /**
     * fonction pour gerer la tri des playlist
     * @Route('/admin/playlists/tri/{champ}/{ordre}', name: 'admin.playlists.sort')
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    #[Route('/admin/playlists/tri/{champ}/{ordre}', name: 'admin.playlists.sort')]
    public function sort($champ, $ordre): Response{
        switch($champ){
            case "name":
                $playlists = $this->playlistRepository->findAllOrderByName($ordre);
                break;
            case "formation":
            //prend toute les playlists
            $playlists = $this->playlistRepository->findAll();

            //tri par le nombre de formation
            usort($playlists, function($a, $b) use ($ordre) {
                // 
                $countA = is_object($a->getFormations()) ? $a->getFormations()->count() : count($a->getFormations());
                $countB = is_object($b->getFormations()) ? $b->getFormations()->count() : count($b->getFormations());

                return $ordre === 'ASC' ? ($countA <=> $countB) : ($countB <=> $countA);
            });
            break;

        default:
            $playlists = $this->playlistRepository->findAll();
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEPLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories
              
        ]);
    }          

    /**
     * fonction pour gerer la filtre des playlists
     * @Route('/admin/playlists/recherche/{champ}/{table}', name: 'admin.playlists.findallcontain')
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    #[Route('/admin/playlists/recherche/{champ}/{table}', name: 'admin.playlists.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEPLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories,            
            'valeur' => $valeur,
            'table' => $table
        ]);
    }
    /**
     * fonction pour gerer la suppression des playlists
     * @Route('/admin/playlists/suppr/{id}', name: 'admin.playlist.suppr') 
     * @param int $id
     * @return Response
     */
    #[Route('/admin/playlists/suppr/{id}', name: 'admin.playlist.suppr')]
    public function suppr(int $id): Response{
        $playlist = $this->playlistRepository->find($id);
        $formations = $this->formationRepository->findAllForOnePlaylist($id);
        if (!empty($formations)){
            $this->addFlash('error','Impossible de supprimer une playlist contenant des formations.');
            return $this->redirectToRoute('admin.playlists');
        }
        $this->playlistRepository->remove($playlist);
        $this->addFlash('success','Playlist supprimée avec succès.');
        return $this->redirectToRoute('admin.playlists');
    }
    /**
     * function pour gerer la modification des playlists
     * @Route ('/admin/playlist/edit/{id}', name:'admin.playlist.edit')
     * @param int $id
     * @param Request $request
     * @return Response
     */
    #[Route ('/admin/playlist/edit/{id}', name:'admin.playlist.edit')]
    public function edit(int $id, Request $request): Response{
        $playlist= $this->playlistRepository->find($id);
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        
        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute('admin.playlists');
        }
                
        return $this->render("admin/admin.playlist.edit.html.twig",[
            'playlist' => $playlist,
            'formplaylist' => $formPlaylist->createView()

            ]);
    }
    /**
     * fonction pour gerer l'ajout d'un playlist
     * @Route('/admin/playlist/ajout', name: 'admin.playlist.ajout')
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/playlist/ajout', name: 'admin.playlist.ajout')]
    public function ajout(Request $request): Response{
        $playlist = new Playlist();
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);

        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute('admin.playlists');
        }

        return $this->render("admin/admin.playlist.ajout.html.twig", [
            'playlist' => $playlist,
            'formplaylist' => $formPlaylist->createView()
        ]);
    }
}
