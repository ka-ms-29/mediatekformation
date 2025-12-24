<?php
namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * PlaylistsController : Controller des Playlists
 *
 * @author emds
 */
class PlaylistsController extends AbstractController {
    
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
    const PAGEPLAYLISTS = "pages/playlists.html.twig";
    /**
     * constant pour enregistrer URL de la page playliste
     */
    const PAGEPLAYLIST = "pages/playlist.html.twig";
    
    /**
     * constructeur de la class PlaylistsController
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
    #[Route('/playlists', name: 'playlists')]
    public function index(): Response{
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEPLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }

    /**
     * fonction pour gerer les tri des playlists
     * @Route('/playlists/tri/{champ}/{ordre}', name: 'playlists.sort')
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    #[Route('/playlists/tri/{champ}/{ordre}', name: 'playlists.sort')]
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
     * @Route('/playlists/recherche/{champ}/{table}', name: 'playlists.findallcontain')
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    #[Route('/playlists/recherche/{champ}/{table}', name: 'playlists.findallcontain')]
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
     * @Route('/playlists/playlist/{id}', name: 'playlists.showone')
     * @param type $id
     * @return Response
     */
    #[Route('/playlists/playlist/{id}', name: 'playlists.showone')]
    public function showOne($id): Response{
        $playlist = $this->playlistRepository->find($id);
        $playlistCategories = $this->categorieRepository->findAllForOnePlaylist($id);
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        return $this->render(self::PAGEPLAYLIST, [
            'playlist' => $playlist,
            'playlistcategories' => $playlistCategories,
            'playlistformations' => $playlistFormations
        ]);        
    }       
    
}
