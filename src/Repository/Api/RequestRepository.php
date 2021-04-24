<?php

namespace App\Repository\Api;

use App\Entity\Api\Request;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Request|null find($id, $lockMode = null, $lockVersion = null)
 * @method Request|null findOneBy(array $criteria, array $orderBy = null)
 * @method Request[]    findAll()
 * @method Request[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    private ?\Symfony\Component\HttpFoundation\Request $httpRequest;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ) {
        $this->entityManager = $entityManager;
        $this->httpRequest = $requestStack->getCurrentRequest();
        parent::__construct($registry, Request::class);
    }

    /**
     * @param string $name
     * @param int $maxCount
     * @param int $timer
     */
    public function sendRequest(string $name, int $maxCount = 3, int $timer = 60)
    {
        $requestsCount = $this->createQueryBuilder('request')
            ->where('request.name = :request')
            ->andWhere('request.userIP = :userIP')
            ->andWhere("request.sendDate >= :date")
            ->setParameter('request', $name)
            ->setParameter('userIP', $this->httpRequest->getClientIp())
            ->setParameter('date', new DateTime("-$timer seconds"))
            ->getQuery()
            ->getScalarResult();

        if (count($requestsCount) < $maxCount) {
            $this->createRequest($name);
        } else {
            $response = new JsonResponse(['error' => 'Превышено количество запросов'], Response::HTTP_TOO_MANY_REQUESTS);
            $response->send();
            exit();
        }
    }

    private function createRequest(string $name)
    {
        $request = new Request();

        $request->setName($name);
        $request->setUserIP($this->httpRequest->getClientIp());
        $request->setSendDate(new DateTime());

        $this->entityManager->persist($request);
        $this->entityManager->flush();
    }
    // /**
    //  * @return Request[] Returns an array of Request objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Request
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
