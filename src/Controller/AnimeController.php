<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\Categories;
use App\Entity\Rating;
use App\Repository\AnimeRepository;
use App\Service\Kodik;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimeController extends AbstractController
{

    protected $request;

    /**
     * @Route("/anime", name="anime")
     */
    public function index(RequestStack $requestStack): Response
    {

        $this->request = $requestStack->getCurrentRequest();

        $arResult['animeList'] = $this->getAllAnime();
        $arResult['categories'] = $this->getAllCategories();

        return $this->render('anime/list.html.twig', $arResult);
    }

    /**
     * @Route("/anime/{id}", name="anime_player")
     *
     * @param $id
     * @param Kodik $kodik
     * @param AnimeRepository $animeRepository
     * @return Response
     */
    public function animePlayer($id, Kodik $kodik, AnimeRepository $animeRepository): Response
    {
        if (!$anime = $animeRepository->find($id)) {
            throw $this->createNotFoundException('Сериал не найден');
        }

        $arRender = $this->getRenderInfoAction($anime, $kodik);

        return $this->render('anime/player.html.twig', $arRender);
    }

    /**
     * @param Anime $anime
     * @param Kodik $kodik
     * @return array
     */
    private function getRenderInfoAction(Anime $anime, Kodik $kodik): array
    {
        $this->addViewAction($anime);

        $ratingRepository = $this->getDoctrine()->getRepository(Rating::class);

        return [
            'anime' => $anime,
            'ratingCount' => $ratingRepository->count(['Anime' => $anime->getId()]),
            'player' => $kodik->getPlayer($anime->getKodikId(), $anime->getIdList())
        ];
    }

    /**
     * @return array
     */
    private function getAllAnime(): array
    {
        //return $this->getDoctrine()->getRepository(Anime::class)->findAll();

        $sortField = $this->request->get('sortField');
        $arSort = ($sortField ? [$sortField => 'ASC'] : ['createdAt' => 'DESC']);

        return $this->getDoctrine()->getRepository(Anime::class)->findBy([], $arSort, 3);
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
