<?php
namespace App\Controller;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * AccueilController : controller d'accueil
 *
 * @author emds
 */
class AccueilController extends AbstractController{
    
    /**
     * @var FormationRepository
     */
    private $repository;
    
    /**
     * constructeur de la class AcceuilController
     * @param FormationRepository $repository
     */
    public function __construct(FormationRepository $repository) {
        $this->repository = $repository;
    }   
    
    /**
     * @Route('/', name: 'accueil')
     * @return Response
     */
    #[Route('/', name: 'accueil')]
    public function index(): Response{
        $formations = $this->repository->findAllLasted(2);
        return $this->render("pages/accueil.html.twig", [
            'formations' => $formations
        ]); 
    }
    
    /**
     * @Route('/cgu', name: 'cgu')
     * @return Response
     */
    #[Route('/cgu', name: 'cgu')]
    public function cgu(): Response{
        return $this->render("pages/cgu.html.twig"); 
    }
}
