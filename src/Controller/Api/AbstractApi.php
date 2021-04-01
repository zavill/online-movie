<?php


namespace App\Controller\Api;

use App\Repository\Api\RequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    protected SessionInterface $session;

    protected RequestRepository $requestRepository;


    /**
     * AbstractApi constructor.
     * @param RequestStack $requestStack
     * @param SessionInterface $session
     * @param RequestRepository $requestRepository
     */
    public function __construct(RequestStack $requestStack, SessionInterface $session, RequestRepository $requestRepository)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->session = $session;
        $this->requestRepository = $requestRepository;
    }
}