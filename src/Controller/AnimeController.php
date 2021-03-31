<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\Categories;
use App\Repository\AnimeRepository;
use App\Service\Kodik;
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
     * @Route("/anime/{id}", name="anime_player")
     *
     * @param $id
     * @param Kodik $kodik
     * @param AnimeRepository $animeRepository
     * @param EntityManager $entityManager
     * @return Response
     */
    public function animePlayer($id, Kodik $kodik, AnimeRepository $animeRepository): Response
    {
        if (!$anime = $animeRepository->find($id)) {
            throw $this->createNotFoundException('Сериал не найден');
        }

        try {
            $arRender = $this->getRenderInfoAction($anime, $kodik);
            return $this->render('anime/player.html.twig', $arRender);
        } catch (\ErrorException $exception) {
            throw $this->createNotFoundException('Сериал не найден');
        }
    }

    /**
     * @param Anime $anime
     * @param Kodik $kodik
     * @return array
     */
    private function getRenderInfoAction(Anime $anime, Kodik $kodik): array
    {
        $this->addViewAction($anime);

        return [
            'anime' => $anime,
            'player' => $kodik->getPlayer($anime->getKodikId(), $anime->getIdList())
        ];
    }

    /**
     * @return array
     */
    private function getAllAnime(): array
    {
        return $this->getDoctrine()->getRepository(Anime::class)->findAll();
    }

    /**
     * @param Anime $anime
     */
    private function addViewAction(Anime $anime)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $anime->addView();

        $entityManager->persist($anime);
        $entityManager->flush();
    }

    /**
     * @return array
     */
    private function getAllCategories(): array
    {
        return $this->getDoctrine()->getRepository(Categories::class)->findAll();
    }
}
