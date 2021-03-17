<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\Categories;
use App\Service\Kodik;
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
        try {
            return $this->render('anime/player.html.twig', ['player' => $kodik->getPlayer($id)]);
        } catch (\ErrorException $exception) {
            return new JsonResponse(['status' => 404, 'text' => 'Сериал не найден'], Response::HTTP_NOT_FOUND);
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
