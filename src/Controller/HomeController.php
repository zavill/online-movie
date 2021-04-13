<?php


namespace App\Controller;


use App\Entity\Anime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $arRenderer['recommendations'] = $this->getRecommendations($entityManager->getRepository(Anime::class));
        return $this->render('home.html.twig', $arRenderer);
    }

    private function getRecommendations(ObjectRepository $animeRepository): array
    {
        return $animeRepository->findBy([], ['createdAt' => 'DESC'], 4);
    }
}