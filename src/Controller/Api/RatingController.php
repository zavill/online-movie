<?php


namespace App\Controller\Api;


use App\Entity\Anime;
use App\Entity\Rating;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rating")
 *
 * Class RatingController
 * @package App\Controller\Api
 */
class RatingController extends AbstractApi
{

    /**
     *
     * @Route("/set/{id<\d+>}")
     * @param $id
     * @return JsonResponse
     */
    public function setRating($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $ratingValue = (int)$this->request->get('rating');

        if ($ratingValue <= 0) {
            return new JsonResponse(
                ['error' => 'Не указан рейтинг'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (!$anime = $entityManager->getRepository(Anime::class)->find($id)) {
            return new JsonResponse(
                ['error' => "Не существует сериала с id $id"],
                Response::HTTP_NOT_FOUND
            );
        }

        $rating = new Rating();
        $rating->setAnime($anime);
        $rating->setRatingValue($ratingValue);

        $entityManager->persist($rating);
        $entityManager->flush();

        return new JsonResponse(
            ['data' => 'Рейтинг успешно добавлен'],
            Response::HTTP_OK
        );
    }
}