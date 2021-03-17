<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimeController extends AbstractController
{
    /**
     * @Route("/anime", name="anime")
     */
    public function index(): Response
    {

        $arResult['anime'] = $this->getAllAnime();
        $arResult['categories'] = $this->getAllCategories();

        return $this->render('anime/index.html.twig', $arResult);
    }

    /**
     * @return array
     */
    private function getAllAnime(): array
    {
        return $this->getDoctrine()->getRepository(Anime::class)->findAll();
    }

    /**
     * @return array
     */
    private function getAllCategories(): array
    {
        return $this->getDoctrine()->getRepository(Categories::class)->findAll();
    }
}
