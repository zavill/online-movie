<?php


namespace App\Controller\Api;

use App\Repository\Api\RequestRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 *
 * Class AbstractApi
 * @package App\Controller\Api
 */
abstract class AbstractApi extends AbstractController
{

    protected ?Request $request;

    protected RequestRepository $requestRepository;

    protected SessionInterface $session;

    protected ObjectManager $entityManager;

    /**
     * AbstractApi constructor.
     * @param RequestStack $requestStack
     * @param RequestRepository $requestRepository
     * @param SessionInterface $session
     */
    public function __construct(
        RequestStack $requestStack,
        RequestRepository $requestRepository,
        SessionInterface $session
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->requestRepository = $requestRepository;

        $this->entityManager = $this->getDoctrine()->getManager();

        $this->session = $session;
        $this->session->start();
    }
}