<?php


namespace App\Controller\Api;

use App\Entity\Anime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/serial")
 *
 * Class SerialApiController
 * @package App\Controller\Api
 */
class SerialApiController extends AbstractApi
{

    /**
     * @Route("/", methods={"GET"})
     */
    public function getList(): JsonResponse
    {
        $this->requestRepository->sendRequest('getSerialList', 15);

        return new JsonResponse(
            ['data' => $this->entityManager->getRepository(Anime::class)->findAll()],
            Response::HTTP_OK
        );
    }

}