<?php


namespace App\Controller\Api;

use App\Entity\Anime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/serial")
 *
 * Class SerialAPIController
 * @package App\Controller\Api
 */
class SerialAPIController extends AbstractApi
{

    /**
     * @Route("/", methods={"GET"})
     */
    public function getList(): JsonResponse
    {
        $arFilter = $this->request->get('filter') ?: [];

        $sortField = $this->request->get('sortField');
        $sort = explode('|', $sortField);
        $arSort = ($sortField ? [$sort[0] => $sort[1]] : []);

        $page = $this->request->get('page') ?: 1;
        $limit = 3;

        $this->requestRepository->sendRequest('getSerialList', 250);

        $rawResult = $this->entityManager->getRepository(Anime::class)->findBy($arFilter, $arSort, $limit, ($page * $limit) - $limit);

        foreach ($rawResult as $serial) {
            $normalizedResult[] = $serial->jsonSerialize();
        }

        return new JsonResponse(
            ['data' => $normalizedResult ?? [], 'debug' => [
                'page' => $page,
                'limit' => $limit,
                'offset' => ($page * $limit) - $limit
            ]],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getSerial($id): JsonResponse
    {
        $this->requestRepository->sendRequest('getSerial', 60);

        return new JsonResponse(
            ['data' => $this->entityManager->getRepository(Anime::class)->find($id)->jsonSerialize()],
            Response::HTTP_OK
        );
    }

}