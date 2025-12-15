<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Description of AdminCategoriesController
 *
 * @author Mostaghfera Jan
 */
class AdminCategoriesController extends AbstractController{
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;
    
    private $formationRepository;
    
    public function __construct(CategorieRepository $categorieRepository, FormationRepository $formationRepository) {
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRepository;
    }
    /**
     * 
     * @return Response
     */
    #[Route('/admin/categories', name:'admin.categories')]
    public function index(): Response{
        $categories = $this->categorieRepository->findAll();
        return $this->render('/admin/admin.categories.html.twig', [
            'categories' => $categories
        ]);
    }
    /**
     * 
     * @param int $id
     * @return Response
     */
    #[Route('/admin/categorie/suppr/{id}', name : 'admin.categorie.suppr')]
    public function suppr(int $id):Response {
        $categorie = $this->categorieRepository->find($id);
        $formations = $this->formationRepository->findAllForOneCategorie($id);

        if (!empty($formations)) {
            $this->addFlash('error', 'Impossible de supprimer une catégorie rattachée à une ou plusieurs formations.');
            return $this->redirectToRoute('admin.categories');
        }

        $this->categorieRepository->remove($categorie);
            
        return $this->redirectToRoute('admin.categories');
    }
    
    /**
     * 
     * @param Reques $request
     * @return Response
     */
    #[Route('/admin/categorie/ajout', name : 'admin.categorie.ajout')]
    public function ajout(Request $request):Response{
        $nomCategorie = $request->get('name');
        if (empty($nomCategorie)) {
            $this->addFlash('error', 'Le champ nom est obligatoire.');
            return $this->redirectToRoute('admin.categories'); 
        }
        $categorieExistante = $this->categorieRepository->findOneBy(['name' => $nomCategorie]);
        if ($categorieExistante) {
            $this->addFlash('error', 'Cette catégorie existe déjà.');
            return $this->redirectToRoute('admin.categories'); 
        }
        $categorie = new Categorie();
        $categorie->setName($nomCategorie);
        $this->categorieRepository->add($categorie);
        return $this->redirectToRoute('admin.categories');
    }
    
    
}
