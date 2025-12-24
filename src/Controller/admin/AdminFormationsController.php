<?php

namespace App\Controller\admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * AdminFormationsController pour : controller de formations partie back-office (admin)
 *
 * @author Mostaghfera Jan
 */
class AdminFormationsController extends AbstractController{
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
     * constant pour sauvegarder la valeur d'url de la page admin/formations
     */
    const PAGEADMINFORMATIONS="admin/admin.formations.html.twig";
    /**
     * constant pour sauvegarder la valeur d'url de la page admin/formation
     */
    const PAGEADMINFORMATION="admin/admin.formation.html.twig";
    
    /**
     * contructeur de la class AdminFormationController
     * @param FormationRepository $formationRepository
     * @param CategorieRepository $categorieRepository
     */
    function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository= $categorieRepository;
    }
    
    /**
     * @Route('/admin', name: 'admin.formations')
     * @return Response
     */
    #[Route('/admin', name: 'admin.formations')]
    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEADMINFORMATIONS, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }
    
    /**
     * fonction pour gerer les tri des formation, partie admin
     * @Route('/admin/formations/tri/{champ}/{ordre}/{table}', name: 'admin.formations.sort')
     * @param type $champ
     * @param type $ordre
     * @param type $table
     * @return Response
     */
    #[Route('/admin/formations/tri/{champ}/{ordre}/{table}', name: 'admin.formations.sort')]
    public function sort($champ, $ordre, $table=""): Response{
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEADMINFORMATIONS, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }     

    /**
     * fonction pour gerer la filtre des formations, partie admin
     * @Route('admin//formations/recherche/{champ}/{table}', name: 'admin.formations.findallcontain')
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    #[Route('admin//formations/recherche/{champ}/{table}', name: 'admin.formations.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEADMINFORMATIONS, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }  
    
    /**
     * fonction pour gerer la suppression d'une formation, partie admin
     * @Route('/admin/suppr/{id}', name: 'admin.formation.suppr')
     * @param int $id
     * @return Response
     */
    #[Route('/admin/suppr/{id}', name: 'admin.formation.suppr')]
    public function suppr(int $id): Response{
        $formation = $this->formationRepository->find($id);
        $this->formationRepository->remove($formation);
        return $this->redirectToRoute('admin.formations');
    }

    /**
     * fonction pour gerer la modification d'une formation, partie admin
     * @Route ('/admin/edit/{id}', name:'admin.formation.edit')
     * @param int $id
     * @param Request $request
     * @return Response
     */
    #[Route ('/admin/edit/{id}', name:'admin.formation.edit')]
    public function edit(int $id, Request $request): Response{
        $formation= $this->formationRepository->find($id);
        $formFormation = $this->createForm(FormationType::class, $formation);
        
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->formationRepository->add($formation);
            return $this->redirectToRoute('admin.formations');
        }
        
        return $this->render("admin/admin.formation.edit.html.twig",[
            'formation' => $formation,
            'formformation' => $formFormation->createView()
            ]);
    }
    /**
     * fonction pour gerer l'ajout d'une formation, partie admin
     * @Route('/admin/ajout', name: 'admin.formation.ajout')
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/ajout', name: 'admin.formation.ajout')]
    public function ajout(Request $request): Response{
        $formation = new Formation();
        $formFormation = $this->createForm(FormationType::class, $formation);

        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->formationRepository->add($formation);
            return $this->redirectToRoute('admin.formations');
        }

        return $this->render("admin/admin.formation.ajout.html.twig", [
            'formation' => $formation,
            'formformation' => $formFormation->createView()
        ]);
    }
      
}
