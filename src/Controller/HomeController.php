<?php


namespace App\Controller;


use App\Entity\Anime;
use App\Entity\Categories;
use App\Repository\AnimeRepository;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(AnimeRepository $animeRepository): Response
    {
        $arRenderer['newSerials'] = $animeRepository->getNewAnime();
        $arRenderer['recommendations'] = $animeRepository->getRecommendations();
        $arRenderer['categories'] = $this->getAllCategories();
        return $this->render('home.html.twig', $arRenderer);
    }

    /**
     * @return array
     */
    private function getAllCategories(): array
    {
        return $this->getDoctrine()->getRepository(Categories::class)->findAll();
    }
}