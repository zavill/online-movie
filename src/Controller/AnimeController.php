<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\Categories;
use App\Service\Kodik;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/anime/{id}", name="anime_player")
     *
     * @param $id
     * @param Kodik $kodik
     * @return Response
     */
    public function animePlayer($id, Kodik $kodik): Response
    {
        if (!$anime = $this->getDoctrine()->getRepository(Anime::class)->find($id)) {
            throw $this->createNotFoundException('Сериал не найден');
        }

        try {
            return $this->render('anime/player.html.twig', ['player' => $kodik->getPlayer($anime->getIdList())]);
        } catch (\ErrorException $exception) {
            throw $this->createNotFoundException('Сериал не найден');
        }
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
