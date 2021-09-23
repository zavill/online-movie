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
 * Class RatingAPIController
 * @package App\Controller\Api
 */
class RatingAPIController extends AbstractApi
{

    /**
     *
     * @Route("/", methods={"POST"})
     * @return JsonResponse
     */
    public function set(): JsonResponse
    {
        $this->requestRepository->sendRequest('setRating', 50);

        if (!$serialId = (int)$this->request->get('serialId')) {
            return new JsonResponse(
                ['error' => 'Не указан ID сериала'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $ratingValue = (int)$this->request->get('rating');

        if ($ratingValue <= 0) {
            return new JsonResponse(
                ['error' => 'Не указан рейтинг'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (!$anime = $this->entityManager->getRepository(Anime::class)->find($serialId)) {
            return new JsonResponse(
                ['error' => "Не существует сериала с id $serialId"],
                Response::HTTP_NOT_FOUND
            );
        }

        if (!$rating = $this->entityManager->getRepository(Rating::class)->findOneBy(
            ['sesionId' => $this->session->getId()]
        )) {
            $rating = new Rating();
            $rating->setAnime($anime);
            $rating->setSesionId($this->session->getId());
        }

        $rating->setRatingValue($ratingValue);

        $this->entityManager->persist($rating);
        $this->entityManager->flush();

        $this->calculateAvgRating($serialId, $anime);

        return new JsonResponse(
            ['data' => $rating->getId()],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getOne(int $id): JsonResponse
    {
        $this->requestRepository->sendRequest('getOneRating', 30);

        if (empty($id)) {
            return new JsonResponse(
                ['error' => 'Не передан ID оценки'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } elseif (!$rating = $this->entityManager->getRepository(Rating::class)->find($id)) {
            return new JsonResponse(
                ['error' => 'Не найдена оценка с указанным ID'],
                Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            ['data' => $rating->jsonSerialize()],
            Response::HTTP_OK
        );
    }


    private function calculateAvgRating($id, Anime $anime)
    {
        $arRating = $this->entityManager->getRepository(Rating::class)->findBy(['Anime' => $id]);

        $ratingList = 0;

        foreach ($arRating as $rating) {
            $ratingList += $rating->getRatingValue();
        }

        $finalRating = round($ratingList / count($arRating), 1);

        $anime->setAverageRating($finalRating);

        $this->entityManager->persist($anime);
        $this->entityManager->flush();
    }

}
