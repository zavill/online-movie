<?php


namespace App\Controller\Api;


use App\Entity\Anime;
use App\Entity\Rating;
use Symfony\Component\HttpClient\Exception\JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/rating")
 *
 * Class RatingController
 * @package App\Controller\Api
 */
class RatingController extends AbstractController
{

    /**
     *
     * @Route("/set/{id<\d+>}")
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function setRating($id, Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ((int)$request->get('rating') <= 0) {
            return new JsonResponse(
                ['error' => 'Не указан рейтинг'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (!$anime = $entityManager->getRepository(Anime::class)->find($id)) {
            return new JsonResponse(
                ['error' => "Не существует сериала с id $id"],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $rating = new Rating();
        $rating->setAnime($anime);
        $rating->setRatingValue((int)$request->get('rating'));

        $entityManager->persist($rating);
        $entityManager->flush();

        return new JsonResponse(
            ['data' => 'Рейтинг успешно добавлен'],
            Response::HTTP_OK
        );
    }
}