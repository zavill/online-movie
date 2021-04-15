<?php


namespace App\Controller;


use App\Entity\Anime;
use App\Repository\AnimeRepository;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(AnimeRepository $animeRepository): Response
    {
        $arRenderer['newSerials'] = $animeRepository->getNewAnime();
        return $this->render('home.html.twig', $arRenderer);
    }
}